<template>
    <AppLayout>
        <div class="dashboard">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Текущий баланс</h5>
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ balance }}</h3>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Последние операции</h5>
                    <div>
                        <small class="text-muted">Обновлено: {{ lastUpdateTime }}</small>
                    </div>
                </div>
                <div class="card-body">
                    <OperationsTable
                        :operations="operations || []"
                        :loading="loading"
                        :headers="[
                        { label: 'Тип', key: 'type', sortable: false },
                        { label: 'Сумма', key: 'amount', sortable: false },
                        { label: 'Статус', key: 'amount', sortable: false },
                        { label: 'Описание', key: 'description', sortable: false },
                        { label: 'Дата', key: 'created_at', sortable: false },
                    ]"
                    />
                </div>
                <div class="card-footer text-muted">
                    <label class="me-2">Обновлять каждые:</label>
                    <select
                        v-model="refreshInterval"
                        class="form-select form-select-sm d-inline-block w-auto"
                        @change="restartAutoRefresh"
                    >
                        <option v-for="option in refreshOptions" :value="option" :key="option">
                            {{ option }} сек
                        </option>
                    </select>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';
import axios from 'axios';
import OperationsTable from '@/components/OperationsTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';

const balance = ref(0);
const operations = ref([]);
const loading = ref(true);
const lastUpdateTime = ref('ещё не обновлялось');
const updateInterval = ref(null);
const refreshInterval = ref(5);
const refreshOptions = [5, 10, 15, 30, 60, 120];

const fetchData = async (initial) => {
    if (initial) {
        loading.value = true;
    }
    try {
        const [balanceResponse, operationsResponse] = await Promise.all([
            axios.get('/api/balance'),
            axios.get('/api/operations/latest')
        ]);

        balance.value = balanceResponse.data.balance;
        operations.value = operationsResponse.data.operations;
        lastUpdateTime.value = new Date().toLocaleTimeString();
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    } finally {
        loading.value = false;
    }
};

const setupAutoRefresh = () => {
    clearInterval(updateInterval.value);
    updateInterval.value = setInterval(() => {
        fetchData();
    }, refreshInterval.value * 1000);
};

const restartAutoRefresh = () => {
    setupAutoRefresh();
};

const clearAutoRefresh = () => {
    if (updateInterval.value) {
        clearInterval(updateInterval.value);
    }
};

onMounted(() => {
    fetchData(true);
    setupAutoRefresh();
});

onBeforeUnmount(() => {
    clearAutoRefresh();
});
</script>

<style scoped>
</style>
