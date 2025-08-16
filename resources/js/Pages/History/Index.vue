<script setup>
import {Link, router} from "@inertiajs/vue3";
import axios from "axios";
import {ref} from "vue";
import Layout from "@/Layouts/Layout.vue";
import Pagination from "@/Components/Pagination.vue";

defineOptions({
    layout: Layout
})

const props = defineProps({
    histories: {
        type: Object,
    }
})

const localHistories = ref([...props.histories.data])

const deleteHistory = async (id) => {
    if (!confirm('Вы уверены, что хотите удалить эту историю?')) {
        return;
    }

    try {
        await axios.delete(route('admin.histories.destroy', id))

        localHistories.value = localHistories.value.filter(history => history.id !== id)

        if (localHistories.value.length === 0 && props.histories.meta.current_page > 1) {
            router.visit(route('admin.histories.index', { page: props.histories.meta.current_page - 1 }))
        }
    } catch (e) {
        console.error('Ошибка при удалении истории', e)
        alert('Ошибка при удалении истории.');
    }
}

const formatAmount = (value) => {
    if (value == null) return '';
    const formatted = Number(value).toLocaleString('ru-RU', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    return formatted.replace(',', '.');
};
</script>

<template>
    <div>
        <div class="flex items-center justify-between mb-6 border-b pb-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">История</h1>
            </div>
            <Link
                :href="route('admin.histories.create')"
                class="inline-flex items-center px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition"
            >
                + Добавить
            </Link>
        </div>
        <div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Тип
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Категория
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ДАТА
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            СУММА
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            КОММЕНТАРИЙ
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Действие
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="history in localHistories" :key="history.id ">
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ history.id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ history.type_label }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ history.category.name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ history.date_format }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ formatAmount(history.amount) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ history.comment }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <Link :href="route('admin.histories.edit', history.id)"
                                  class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out"
                            >
                                Редактировать
                            </Link>
                            <button @click="deleteHistory(history.id)" class="ml-2 px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-red active:bg-red-600 transition duration-150 ease-in-out">
                                Удалить
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <Pagination :links="histories.meta.links" mode="inertia" />
        </div>
    </div>
</template>

<style scoped>

</style>
