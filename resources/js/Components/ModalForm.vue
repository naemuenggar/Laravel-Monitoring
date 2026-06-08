<script setup>
import Modal from '@/Components/Modal.vue';
import { X } from 'lucide-vue-next';

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
        default: '',
    },
    maxWidth: {
        type: String,
        default: 'lg',
    },
});

const emit = defineEmits(['close']);
</script>

<template>
    <Modal :show="show" :max-width="maxWidth" @close="emit('close')">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ title }}</h2>
            <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200" @click="emit('close')">
                <X class="h-5 w-5" />
            </button>
        </div>

        <div class="px-6 py-5">
            <slot />
        </div>

        <div v-if="$slots.footer" class="flex justify-end gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4 dark:border-gray-700 dark:bg-gray-800">
            <slot name="footer" />
        </div>
    </Modal>
</template>
