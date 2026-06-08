<script setup>
import { computed } from 'vue';
import { Bar, Line } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Filler,
} from 'chart.js';

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Filler,
);

const props = defineProps({
    title: String,
    type: {
        type: String,
        default: 'line', // 'line' | 'bar'
    },
    labels: {
        type: Array,
        default: () => [],
    },
    data: {
        type: Array,
        default: () => [],
    },
    label: {
        type: String,
        default: 'Value',
    },
    color: {
        type: String,
        default: '#6366f1',
    },
});

const chartData = computed(() => ({
    labels: props.labels,
    datasets: [
        {
            label: props.label,
            data: props.data,
            backgroundColor:
                props.type === 'bar'
                    ? ['#6366f1', '#0ea5e9', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6']
                    : 'rgba(99, 102, 241, 0.15)',
            borderColor: props.color,
            borderWidth: 2,
            borderRadius: props.type === 'bar' ? 6 : 0,
            tension: 0.4,
            fill: props.type === 'line',
            pointBackgroundColor: props.color,
        },
    ],
}));

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: false },
    },
    scales: {
        y: {
            beginAtZero: true,
            grid: { color: 'rgba(148, 163, 184, 0.15)' },
            ticks: { precision: 0 },
        },
        x: {
            grid: { display: false },
        },
    },
};
</script>

<template>
    <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-gray-100">{{ title }}</h3>
        <div class="h-72">
            <Bar v-if="type === 'bar'" :data="chartData" :options="chartOptions" />
            <Line v-else :data="chartData" :options="chartOptions" />
        </div>
    </div>
</template>
