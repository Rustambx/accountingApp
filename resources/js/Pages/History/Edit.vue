<script setup>
import {Link, router} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import axios from "axios";
import Layout from "@/Layouts/Layout.vue";

defineOptions({
    layout: Layout
})

const props = defineProps({
    categories: {
        type: Array,
    },
    types: {
        type: Array,
    },
    history: {
        type: Object
    }

})

const history = ref({
    amount: props.history.amount || '',
    date: props.history.date || '',
    comment: props.history.comment || '',
    type: props.history.type || '',
    category_id: props.history.category_id || ''
})

const errors = ref([])

const filteredCategories = computed(() => {
    if (!history.value.type) {
        return [];
    }

    return props.categories.filter(category => category.type === history.value.type);
})

const updateHistory = async () => {
    try {
        const res = await axios.put(route('admin.histories.update', props.history.id), history.value)

        // console.log('История успешно обновлена:', res.data)

        router.visit(route('admin.histories.index'));

    } catch (e) {
        errors.value = e.response.data.errors

        console.error('Ошибка при обновлении истории:', e)
    }
}
</script>

<template>
    <div>
        <div class="flex items-center justify-between mb-6 border-b pb-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Редактирование истории</h1>
            </div>
        </div>
        <div>
            <div class="mb-4">
                <label for="amount" class="block mb-1">Сумма</label>
                <input id="amount" type="number" v-model="history.amount" class="border border-gray-200 p-2 w-1/4" placeholder="Сумма">
                <div v-if="errors['amount']" class="text-red-600">
                    <p v-for="error in errors['amount']">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div class="mb-4">
                <label for="date" class="block mb-1">Дата</label>
                <input id="date" type="datetime-local" v-model="history.date" class="border border-gray-200 p-2 w-1/4" placeholder="Дата">
                <div v-if="errors['date']" class="text-red-600">
                    <p v-for="error in errors['date']">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div class="mb-4">
                <label for="comment" class="block mb-1">Комментарий</label>
                <input id="comment" type="text" v-model="history.comment" class="border border-gray-200 p-2 w-1/4" placeholder="Комментарий">
                <div v-if="errors['comment']" class="text-red-600">
                    <p v-for="error in errors['comment']">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div class="mb-4">
                <label for="type" class="block mb-1">Тип</label>
                <select v-model="history.type" id="type" class="border border-gray-200 p-2 w-1/4">
                    <option value="">Выберите тип</option>
                    <option v-for="type in types" :key="type.value" :value="type.value">
                        {{ type.label }}
                    </option>
                </select>
                <div v-if="errors['type']" class="text-red-600">
                    <p v-for="error in errors['type']">
                        {{ error }}
                    </p>
                </div>
            </div>

            <div class="mb-4">
                <label for="category_id" class="block mb-1">Категория</label>
                <select v-model="history.category_id" id="category_id" class="border border-gray-200 p-2 w-1/4">
                    <option value="">Выберите категорию</option>
                    <option v-for="cat in filteredCategories" :key="cat.id" :value="cat.id">
                        {{ cat.name }}
                    </option>
                </select>
                <div v-if="errors['category_id']" class="text-red-600">
                    <p v-for="error in errors['category_id']">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div class="mb-4 flex gap-3">
                <button
                    @click="updateHistory"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow
               hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
                >
                    Редактировать
                </button>

                <Link
                    :href="route('admin.histories.index')"
                    class="inline-flex items-center px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg shadow
               hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition"
                >
                    Назад к списку
                </Link>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
