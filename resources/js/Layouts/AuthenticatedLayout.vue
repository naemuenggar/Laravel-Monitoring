<script setup>
import { ref } from 'vue';
import Sidebar from '@/Components/Sidebar.vue';
import Header from '@/Components/Header.vue';
import FlashMessage from '@/Components/FlashMessage.vue';

defineProps({
    title: {
        type: String,
        default: 'Dashboard',
    },
});

const sidebarOpen = ref(false);
</script>

<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <Sidebar :open="sidebarOpen" @close="sidebarOpen = false" />

        <div class="lg:pl-64">
            <Header :title="title" @toggle-sidebar="sidebarOpen = !sidebarOpen" />

            <main class="p-4 sm:p-6">
                <slot />
            </main>
        </div>

        <FlashMessage />
    </div>
</template>
