<script setup>
defineProps({
    title: String,
    value: [String, Number],
    icon: [Object, Function],
    trend: {
        type: String,
        default: null,
    },
    color: {
        type: String,
        default: 'indigo',
    },
});

const colorMap = {
    indigo: 'bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400',
    emerald: 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400',
    amber: 'bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400',
    sky: 'bg-sky-100 text-sky-600 dark:bg-sky-500/20 dark:text-sky-400',
};
</script>

<template>
    <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ title }}</p>
                <p class="mt-2 text-3xl font-bold text-gray-800 dark:text-gray-100">{{ value }}</p>
            </div>
            <div :class="['flex h-12 w-12 items-center justify-center rounded-lg', colorMap[color]]">
                <component :is="icon" class="h-6 w-6" />
            </div>
        </div>
        <p v-if="trend" class="mt-3 text-xs text-gray-400">{{ trend }}</p>
    </div>
</template>
