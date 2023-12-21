<template>
    <div v-show="message">
        <p class="text-sm text-red-600 dark:text-red-400">
            {{ message }}
        </p>
    </div>
</template>

<script setup>
defineProps({
    message: {
        type: [String, null],
        default: null
    },
});
</script>
