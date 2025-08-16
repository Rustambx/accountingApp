<script setup>
import {Link, useForm} from "@inertiajs/vue3";

const props = defineProps({
    auth: Object
});

const logoutForm = useForm();
const logout = () => {
    logoutForm.post(route('logout'));
};

</script>

<template>
    <section class="w-full p-4 border-b border-gray-100 flex justify-between items-center">
        <header class="text-xl font-bold">
            ДОМАШНЯЯ БУХГАЛТЕРИЯ
        </header>
        <div class="flex items-center gap-4">
            <span class="text-gray-700">{{ props.auth.user.name }}</span>
            <button
                @click="logout"
                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-500"
            >
                Выйти
            </button>
        </div>
    </section>
    <section class="flex">
        <aside class="w-1/4 bg-gray-900 min-h-screen">
            <nav>
                <Link :href="route('admin.dashboard')" class="block p-4 text-gray-200 border-b border-gray-600">Отчёт</Link>
                <Link :href="route('admin.categories.index')" class="block p-4 text-gray-200 border-b border-gray-600">Категории</Link>
                <Link :href="route('admin.histories.index')" class="block p-4 text-gray-200 border-b border-gray-600">История</Link>
            </nav>
        </aside>
        <article class="w-3/4 bg-gray-50 p-4">
            <slot/>
        </article>
    </section>
    <section>
        <footer>

        </footer>
    </section>
</template>

<style scoped>

</style>
