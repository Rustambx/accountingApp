<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    links: Array,
    mode: { type: String, default: 'inertia' }
})

const emit = defineEmits(['navigate'])
</script>

<template>
    <div class="flex justify-center items-center gap-2 mt-4">
        <template v-for="(link, i) in links" :key="i">
      <span
          v-if="!link.url"
          class="px-3 py-1 text-gray-400 border rounded cursor-not-allowed"
      >
        {{ link.label.includes('Previous') ? 'Предыдущая' : link.label.includes('Next') ? 'Следующая' : link.label }}
      </span>

            <template v-else>
                <button
                    v-if="mode === 'async'"
                    @click="emit('navigate', link.url)"
                    class="px-3 py-1 border rounded"
                    :class="{
            'bg-blue-500 text-white': link.active,
            'hover:bg-gray-100': !link.active,
          }"
                >
                    {{ link.label.includes('Previous') ? 'Предыдущая' : link.label.includes('Next') ? 'Следующая' : link.label }}
                </button>

                <Link
                    v-else
                    :href="link.url"
                    class="px-3 py-1 border rounded"
                    :class="{
            'bg-blue-500 text-white': link.active,
            'hover:bg-gray-100': !link.active,
          }"
                >
                    {{ link.label.includes('Previous') ? 'Предыдущая' : link.label.includes('Next') ? 'Следующая' : link.label }}
                </Link>
            </template>
        </template>
    </div>
</template>
