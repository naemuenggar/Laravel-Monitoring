<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import StatCard from '@/Components/StatCard.vue';
import ChartCard from '@/Components/ChartCard.vue';
import Badge from '@/Components/Badge.vue';
import { Users, Boxes, FileBarChart, Activity } from 'lucide-vue-next';

defineProps({
    stats: Object,
    lineChart: Object,
    barChart: Object,
    recentActivities: Array,
});

const typeDot = {
    success: 'bg-emerald-500',
    info: 'bg-sky-500',
    warning: 'bg-amber-500',
    danger: 'bg-red-500',
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout title="Dashboard">
        <div class="space-y-6">
            <!-- Stat cards -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
                <StatCard title="Total Users" :value="stats.users" :icon="Users" color="indigo" trend="Registered accounts" />
                <StatCard title="Total Products" :value="stats.products" :icon="Boxes" color="sky" trend="Monitoring entries" />
                <StatCard title="Total Reports" :value="stats.reports" :icon="FileBarChart" color="amber" trend="Generated reports" />
                <StatCard title="Total Active Data" :value="stats.active" :icon="Activity" color="emerald" trend="Currently active" />
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <ChartCard
                        title="Monthly Data Overview"
                        type="line"
                        label="Entries"
                        :labels="lineChart.labels"
                        :data="lineChart.data"
                    />
                </div>
                <ChartCard
                    title="Data by Category"
                    type="bar"
                    label="Count"
                    :labels="barChart.labels"
                    :data="barChart.data"
                />
            </div>

            <!-- Recent activities -->
            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-gray-100">Recent Activities</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                <th class="px-4 py-3">User</th>
                                <th class="px-4 py-3">Activity</th>
                                <th class="px-4 py-3">Type</th>
                                <th class="px-4 py-3">When</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <tr v-if="recentActivities.length === 0">
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-400">No recent activity.</td>
                            </tr>
                            <tr v-for="item in recentActivities" :key="item.id" class="text-sm text-gray-700 dark:text-gray-300">
                                <td class="whitespace-nowrap px-4 py-3 font-medium">{{ item.user }}</td>
                                <td class="px-4 py-3">{{ item.description }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1.5">
                                        <span :class="['h-2 w-2 rounded-full', typeDot[item.type] || 'bg-gray-400']"></span>
                                        <span class="capitalize">{{ item.type }}</span>
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-400">{{ item.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
