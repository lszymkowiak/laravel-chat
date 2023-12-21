<template>
    <Head title="API Tokens" />

    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                API Tokens
            </h2>
        </div>
    </header>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <ApiTokenManager
                    :tokens="tokens"
                    :available-permissions="availablePermissions"
                    :default-permissions="defaultPermissions"
            />
        </div>
    </div>
</template>

<script setup>
import ApiTokenManager from '@/views/API/Partials/ApiTokenManager.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import {Head} from "@inertiajs/vue3";

defineProps({
    tokens: {
        type: Array,
        default: () => []
    },
    availablePermissions: {
        type: Array,
        default: () => []
    },
    defaultPermissions: {
        type: Array,
        default: () => []
    },
});
</script>
