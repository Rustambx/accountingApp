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
    categories: {
        type: Object,
    }
})

const localCategories = ref([...props.categories.data])

const deleteCategory = async (id) => {
    if (!confirm('Вы уверены, что хотите удалить эту категорию?')) {
        return;
    }

    try {
        await axios.delete(route('admin.categories.destroy', id))

        localCategories.value = localCategories.value.filter(category => category.id !== id)

        if (localCategories.value.length === 0 && props.categories.meta.current_page > 1) {
            router.visit(route('admin.categories.index', {page:props.categories.meta.current_page - 1}))
        }
    } catch (e) {
        console.error('Ошибка при удалении категории', e)
        alert('Ошибка при удалении категории.');
    }
}
</script>

<template>
    <div>
        <div class="flex items-center justify-between mb-6 border-b pb-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Список категории</h1>
            </div>
            <Link
                :href="route('admin.categories.create')"
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
                            Заголовок
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Тип
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Действие
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="category in localCategories">
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ category.id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ category.name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ category.type_label }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <Link :href="route('admin.categories.edit', category.id)"
                                  class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out"
                            >
                                Редактировать
                            </Link>
                            <button @click="deleteCategory(category.id)" class="ml-2 px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-red active:bg-red-600 transition duration-150 ease-in-out">
                                Удалить
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <Pagination :links="categories.meta.links" mode="inertia" />
        </div>
    </div>
</template>

<style scoped>

</style>
