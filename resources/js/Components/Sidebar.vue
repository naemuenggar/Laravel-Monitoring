<script setup>
import { Link } from '@inertiajs/vue3';
import {
    LayoutDashboard,
    Users,
    Boxes,
    FileBarChart,
    Settings,
    X,
    Activity,
} from 'lucide-vue-next';

defineProps({
    open: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);

const navigation = [
    { name: 'Dashboard', route: 'dashboard', icon: LayoutDashboard, active: 'dashboard' },
    { name: 'Users', route: 'users.index', icon: Users, active: 'users.*' },
    { name: 'Monitoring Data', route: 'monitoring-data.index', icon: Boxes, active: 'monitoring-data.*' },
    { name: 'Reports', route: 'reports.index', icon: FileBarChart, active: 'reports.*' },
    { name: 'Settings', route: 'settings.index', icon: Settings, active: 'settings.*' },
];
</script>

<template>
    <!-- Mobile backdrop -->
    <div
        v-show="open"
        class="fixed inset-0 z-30 bg-gray-900/50 lg:hidden"
        @click="emit('close')"
    />

    <aside
        :class="[
            'fixed inset-y-0 left-0 z-40 w-64 transform bg-slate-900 text-slate-300 transition-transform duration-200 ease-in-out lg:translate-x-0',
            open ? 'translate-x-0' : '-translate-x-full',
        ]"
    >
        <div class="flex h-16 items-center justify-between border-b border-slate-800 px-6">
            <div class="flex items-center gap-2">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600">
                    <Activity class="h-5 w-5 text-white" />
                </div>
                <span class="text-lg font-semibold text-white">Monitoring</span>
            </div>
            <button class="text-slate-400 hover:text-white lg:hidden" @click="emit('close')">
                <X class="h-6 w-6" />
            </button>
        </div>

        <nav class="mt-4 space-y-1 px-3">
            <Link
                v-for="item in navigation"
                :key="item.name"
                :href="route(item.route)"
                @click="emit('close')"
                :class="[
                    'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors',
                    route().current(item.active)
                        ? 'bg-indigo-600 text-white shadow'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white',
                ]"
            >
                <component :is="item.icon" class="h-5 w-5 shrink-0" />
                {{ item.name }}
            </Link>
        </nav>

        <div class="absolute bottom-0 w-full border-t border-slate-800 p-4 text-xs text-slate-500">
            Admin Monitoring Dashboard
            <div class="text-slate-600">v1.0.0</div>
        </div>
    </aside>
</template>
