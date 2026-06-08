<script setup>
import Pagination from '@/Components/Pagination.vue';

defineProps({
    columns: {
        type: Array,
        required: true, // [{ key: 'name', label: 'Name' }]
    },
    rows: {
        type: Array,
        default: () => [],
    },
    links: {
        type: Array,
        default: () => [],
    },
    meta: {
        type: Object,
        default: null, // { from, to, total }
    },
});
</script>

<template>
    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th
                            v-for="column in columns"
                            :key="column.key"
                            class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"
                        >
                            {{ column.label }}
                        </th>
                        <th v-if="$slots.actions" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <tr v-if="rows.length === 0">
                        <td :colspan="columns.length + ($slots.actions ? 1 : 0)" class="px-6 py-10 text-center text-sm text-gray-400">
                            No data found.
                        </td>
                    </tr>
                    <tr
                        v-for="row in rows"
                        :key="row.id"
                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700/40"
                    >
                        <td
                            v-for="column in columns"
                            :key="column.key"
                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-700 dark:text-gray-300"
                        >
                            <slot :name="`cell-${column.key}`" :row="row" :value="row[column.key]">
                                {{ row[column.key] }}
                            </slot>
                        </td>
                        <td v-if="$slots.actions" class="whitespace-nowrap px-6 py-4 text-right text-sm">
                            <slot name="actions" :row="row" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div
            v-if="links.length"
            class="flex flex-col items-center justify-between gap-3 border-t border-gray-100 px-6 py-4 dark:border-gray-700 sm:flex-row"
        >
            <p v-if="meta" class="text-sm text-gray-500 dark:text-gray-400">
                Showing {{ meta.from ?? 0 }} to {{ meta.to ?? 0 }} of {{ meta.total }} results
            </p>
            <Pagination :links="links" />
        </div>
    </div>
</template>
