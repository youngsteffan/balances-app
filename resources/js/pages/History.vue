<script setup lang="ts">
import { onMounted, reactive, ref, watch } from 'vue';
import axios from 'axios';
import { debounce } from 'lodash-es';
import OperationsTable from '@/components/OperationsTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';

let operations = reactive({});
const loading = ref(true);
const searchQuery = ref('');
const sort = ref({ field: 'created_at', direction: 'desc' });

watch(sort, () => {
    fetchOperations();
}, { deep: true });

const fetchOperations = async (page: number = 1) => {
    try {
        loading.value = true;
        const { data } = await axios.get('/api/operations', {
            params: {
                page: page,
                search: searchQuery.value,
                sort: sort.value.field,
                direction: sort.value.direction
            }
        });
        operations = data;
    } catch (error) {
        console.error('Ошибка загрузки операций:', error);
    } finally {
        loading.value = false;
    }
};

const changePage = (page: number) => {
    if (page < 1 || page > operations.last_page) return;
    fetchOperations(page);
};

const debounceSearch = debounce(() => fetchOperations(), 500);

onMounted(fetchOperations);
</script>

<template>
    <AppLayout>
        <div class="history">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h2 class="h5 mb-0">История операций</h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="input-group">
                        <span class="input-group-text">
                          <i class="bi bi-search"></i>
                        </span>
                            <input
                                v-model="searchQuery"
                                type="text"
                                class="form-control"
                                placeholder="Поиск по описанию..."
                                @input="debounceSearch"
                            >
                        </div>
                    </div>
                    <OperationsTable
                        v-model:sort="sort"
                        :operations="operations.data || []"
                        :loading="loading"
                        :headers="[
                        { label: 'Тип', key: 'type', sortable: false },
                        { label: 'Сумма', key: 'amount', sortable: true },
                        { label: 'Статус', key: 'status', sortable: false },
                        { label: 'Описание', key: 'description', sortable: false },
                        { label: 'Дата', key: 'created_at', sortable: true },
                    ]"
                    />

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Показано с {{ operations.from }} по {{ operations.to }} из {{ operations.total }} операций
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                <li class="page-item" :class="{ disabled: !operations.prev_page_url }">
                                    <button
                                        class="page-link"
                                        @click="changePage(operations.current_page - 1)"
                                    >
                                        &laquo;
                                    </button>
                                </li>

                                <li
                                    v-for="page in operations.last_page"
                                    :key="page"
                                    class="page-item"
                                    :class="{ active: page === operations.current_page }"
                                >
                                    <button
                                        class="page-link"
                                        @click="changePage(page)"
                                    >
                                        {{ page }}
                                    </button>
                                </li>

                                <li class="page-item" :class="{ disabled: !operations.next_page_url }">
                                    <button
                                        class="page-link"
                                        @click="changePage(operations.current_page + 1)"
                                    >
                                        &raquo;
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
