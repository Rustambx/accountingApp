<script setup>
import { computed, ref } from "vue";
import axios from "axios";
import Layout from "@/Layouts/Layout.vue";
import Pagination from "@/Components/Pagination.vue";

defineOptions({
    layout: Layout
})

const props = defineProps({
    histories: Object,
});

const filters = ref({
    type: "",
    category_id: "",
    date_from: "",
    date_to: "",
});

const localHistories = ref({ ...props.histories });

const formatAmount = (value) => {
    if (value == null) return '';
    const formatted = Number(value).toLocaleString('ru-RU', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    return formatted.replace(',', '.');
};

const getAmountClass = (type) => type === 'income' ? 'text-green-600 font-bold' : 'text-red-600 font-bold';

const getFormattedAmount = (type, amount) => {
    const sign = type === 'income' ? '+' : '-';
    return `${sign} ${formatAmount(amount)}`;
};

const historiesWithTotal = computed(() => {
    let runningTotal = 0;
    return localHistories.value.data.map(history => {
        const amount = parseFloat(history.amount) || 0;
        if (history.type === 'income') runningTotal += amount;
        else if (history.type === 'expense') runningTotal -= amount;

        return { ...history, cumulativeTotal: runningTotal };
    });
});

const fetchHistories = async (url = '/api/histories') => {
    try {
        let params = { ...filters.value };
        if (url.includes('?')) {
            const queryString = url.split('?')[1];
            const searchParams = new URLSearchParams(queryString);
            searchParams.forEach((v, k) => params[k] = v);
        }

        const response = await axios.get('/api/histories', { params });
        localHistories.value = response.data;
    } catch (e) {
        console.error('Ошибка при загрузке историй', e);
    }
};
</script>

<template>
    <div>
        <div class="flex items-center justify-between mb-6 border-b pb-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Отчёт по историю</h1>
            </div>
        </div>

        <div class="mb-4 flex gap-2">
            <select v-model="filters.type" @change="fetchHistories()" class="border border-gray-200">
                <option value="">Все типы</option>
                <option value="income">Доход</option>
                <option value="expense">Расход</option>
            </select>

            <select v-model="filters.category_id" @change="fetchHistories()" class="border border-gray-200">
                <option value="">Все категории</option>
                <option
                    v-for="cat in localHistories.meta?.categories || []"
                    :key="cat.id"
                    :value="cat.id"
                    v-show="!filters.type || filters.type === cat.type"
                >
                    {{ cat.name }}
                </option>
            </select>

            <input type="date" v-model="filters.date_from" @change="fetchHistories()" class="border border-gray-200" />
            <input type="date" v-model="filters.date_to" @change="fetchHistories()" class="border border-gray-200" />
        </div>

        <div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Тип</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Категория</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Сумма</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Итого</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Комментарий</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="history in historiesWithTotal" :key="history.id">
                    <td class="px-6 py-4 whitespace-nowrap">{{ history.type_label }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ history.category.name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ history.date_format }}</td>
                    <td :class="['px-6 py-4 whitespace-nowrap', getAmountClass(history.type)]">{{ getFormattedAmount(history.type, history.amount) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ formatAmount(history.cumulativeTotal) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ history.comment }}</td>
                </tr>
                </tbody>
            </table>

            <Pagination :links="localHistories.meta?.links" mode="async" @navigate="fetchHistories" />
        </div>
    </div>
</template>

<style scoped></style>
