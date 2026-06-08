<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Menu, Bell, Search } from 'lucide-vue-next';

defineProps({
    title: {
        type: String,
        default: 'Dashboard',
    },
});

const emit = defineEmits(['toggle-sidebar']);

const user = computed(() => usePage().props.auth.user);
const initials = computed(() => {
    const name = user.value?.name ?? 'A';
    return name
        .split(' ')
        .map((n) => n[0])
        .slice(0, 2)
        .join('')
        .toUpperCase();
});
</script>

<template>
    <header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-gray-200 bg-white px-4 dark:border-gray-700 dark:bg-gray-800 sm:px-6">
        <div class="flex items-center gap-3">
            <button
                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 lg:hidden"
                @click="emit('toggle-sidebar')"
            >
                <Menu class="h-6 w-6" />
            </button>
            <h1 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ title }}</h1>
        </div>

        <div class="flex items-center gap-3">
            <div class="relative hidden md:block">
                <Search class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                <input
                    type="text"
                    placeholder="Search..."
                    class="w-56 rounded-lg border-gray-300 bg-gray-50 pl-9 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                />
            </div>

            <button class="relative rounded-full p-2 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                <Bell class="h-5 w-5" />
                <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-red-500"></span>
            </button>

            <Dropdown align="right" width="48">
                <template #trigger>
                    <button class="flex items-center gap-2 rounded-lg p-1 pr-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-600 text-sm font-semibold text-white">
                            {{ initials }}
                        </span>
                        <span class="hidden text-sm font-medium text-gray-700 dark:text-gray-200 sm:block">
                            {{ user?.name }}
                        </span>
                    </button>
                </template>
                <template #content>
                    <div class="border-b border-gray-100 px-4 py-2 dark:border-gray-700">
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ user?.name }}</p>
                        <p class="truncate text-xs text-gray-500">{{ user?.email }}</p>
                    </div>
                    <DropdownLink :href="route('settings.index')">Settings</DropdownLink>
                    <DropdownLink :href="route('logout')" method="post" as="button">
                        Log Out
                    </DropdownLink>
                </template>
            </Dropdown>
        </div>
    </header>
</template>
