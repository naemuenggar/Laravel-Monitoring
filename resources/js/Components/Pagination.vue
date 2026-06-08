<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <div v-if="links.length > 3" class="flex flex-wrap items-center gap-1">
        <template v-for="(link, index) in links" :key="index">
            <span
                v-if="link.url === null"
                class="rounded-md px-3 py-2 text-sm text-gray-400"
                v-html="link.label"
            />
            <Link
                v-else
                :href="link.url"
                preserve-scroll
                :class="[
                    'rounded-md px-3 py-2 text-sm transition-colors',
                    link.active
                        ? 'bg-indigo-600 text-white'
                        : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700',
                ]"
                v-html="link.label"
            />
        </template>
    </div>
</template>
