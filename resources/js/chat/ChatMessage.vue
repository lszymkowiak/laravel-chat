<template>
    <div class="h-96 p-2 space-y-2 overflow-y-auto">
        <div v-for="(message, messageIdx) in messages" :key="messageIdx" class="bg-gray-100 p-2 rounded-md text-sm">
            {{ message.content }}
            <div class="text-xs text-gray-500 text-right">
                {{ message.date }}
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    messages: {
        type: Array,
        required: true
    }
})
</script>
