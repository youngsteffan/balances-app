<script setup lang="ts">

const props = defineProps({
    operations: {
        type: Array,
        required: true
    },
    sort: {
        type: Object,
        default: null
    },
    loading: {
        type: Boolean,
        default: false
    },
    headers: {
        type: Array,
        required: true
    }
});

const emit = defineEmits(['update:sort']);

const sortIcon = (field: string) => {
    if (props.sort.field !== field) return 'bi-arrow-down-up';
    return props.sort.direction === 'asc' ? 'bi-arrow-up' : 'bi-arrow-down';
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const handleSort = (field: string, canSort: boolean) => {
    if (!canSort) return;

    let direction = 'desc';

    if (props.sort.field === field) {
        direction = props.sort.direction === 'asc' ? 'desc' : 'asc';
    }

    emit('update:sort', { field, direction });
};
</script>

<template>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
            <tr>
                <th
                    v-for="header in headers"
                    :key="header.key"
                    :class="{'cursor-pointer': header.sortable}"
                    @click="handleSort(header.key, header.sortable)"
                >
                    {{ header.label }}
                    <i v-if="header.sortable" class="bi ms-1" :class="sortIcon(header.key)"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="loading">
                <td colspan="4" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Загрузка...</span>
                    </div>
                </td>
            </tr>
            <template v-else>
                <tr v-for="operation in operations" :key="operation.id">
                    <td>
                        <span class="badge" :class="{
                            'bg-success': operation.type === 'deposit',
                            'bg-danger': operation.type === 'withdraw'
                        }">
                            {{ operation.type === 'deposit' ? 'Пополнение' : 'Списание' }}
                        </span>
                    </td>
                    <td>{{ operation.amount }}</td>
                    <td>{{ operation.status }}</td>
                    <td>{{ operation.description }}</td>
                    <td>{{ formatDate(operation.created_at) }}</td>
                </tr>
                <tr v-if="!operations || operations.length === 0">
                    <td colspan="5" class="text-center text-muted py-4">
                        Нет операций
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
