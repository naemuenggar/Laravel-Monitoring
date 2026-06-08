<script setup>
import { computed } from 'vue';

const props = defineProps({
    value: {
        type: String,
        default: '',
    },
});

const styles = {
    active: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400',
    completed: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400',
    inactive: 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300',
    pending: 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400',
    failed: 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400',
    admin: 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-400',
    editor: 'bg-sky-100 text-sky-700 dark:bg-sky-500/20 dark:text-sky-400',
    user: 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300',
};

const cls = computed(() => styles[props.value?.toLowerCase()] ?? 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300');
</script>

<template>
    <span :class="['inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize', cls]">
        {{ value }}
    </span>
</template>
