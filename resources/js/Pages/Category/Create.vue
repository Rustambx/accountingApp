<script setup>
import {Link, router} from "@inertiajs/vue3";
import {ref} from "vue";
import axios from "axios";
import Layout from "@/Layouts/Layout.vue";

defineOptions({
    layout: Layout
})

const props = defineProps({
    types: {
        type: Array,
        required: true
    }
});

const category = ref({
    name: '',
    type: ''
})

const errors = ref([])

const storeCategory = async () => {
    try {
        const res = await axios.post(route('admin.categories.store'), category.value)

        // console.log('Категория успешно создана:', res.data)

        router.visit(route('admin.categories.index'))
    } catch (e) {
        errors.value = e.response.data.errors

        console.error('Ошибка при создании категории:', e)
    }
}
</script>

<template>
    <div>
        <div class="flex items-center justify-between mb-6 border-b pb-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Добавление категории</h1>
            </div>
        </div>
        <div>
            <div class="mb-4">
                <label for="name" class="block mb-1">Название</label>
                <input type="text" v-model="category.name" id="name" class="border border-gray-200 p-2 w-1/4" placeholder="Название">
                <div v-if="errors['name']" class="text-red-600">
                    <p v-for="error in errors['name']">
                        {{ error }}
                    </p>
                </div>
            </div>
            <div class="mb-4">
                <label for="type" class="block mb-1">Тип</label>
                <select v-model="category.type" id="type" class="border border-gray-200 p-2 w-1/4">
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
            <div class="mb-4 flex gap-3">
                <button
                    @click="storeCategory"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow
               hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
                >
                    Добавить
                </button>

                <Link
                    :href="route('admin.categories.index')"
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
