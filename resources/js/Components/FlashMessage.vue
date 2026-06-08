<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { CheckCircle2, XCircle, X } from 'lucide-vue-next';

const page = usePage();
const show = ref(false);
const message = ref('');
const type = ref('success');

const flash = computed(() => page.props.flash);

watch(
    flash,
    (value) => {
        if (value?.success) {
            message.value = value.success;
            type.value = 'success';
            trigger();
        } else if (value?.error) {
            message.value = value.error;
            type.value = 'error';
            trigger();
        }
    },
    { immediate: true, deep: true },
);

let timer = null;
function trigger() {
    show.value = true;
    clearTimeout(timer);
    timer = setTimeout(() => (show.value = false), 3500);
}
</script>

<template>
    <Transition
        enter-active-class="transition duration-300"
        enter-from-class="translate-y-2 opacity-0"
        leave-active-class="transition duration-200"
        leave-to-class="opacity-0"
    >
        <div
            v-if="show"
            class="fixed bottom-6 right-6 z-50 flex items-center gap-3 rounded-lg bg-white px-4 py-3 shadow-lg ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700"
        >
            <CheckCircle2 v-if="type === 'success'" class="h-5 w-5 text-emerald-500" />
            <XCircle v-else class="h-5 w-5 text-red-500" />
            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ message }}</span>
            <button class="text-gray-400 hover:text-gray-600" @click="show = false">
                <X class="h-4 w-4" />
            </button>
        </div>
    </Transition>
</template>
