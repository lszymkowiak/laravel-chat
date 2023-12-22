<template>
    <div class="shrink-0 mr-2">
        <img class="size-8 rounded-full object-cover" :src="user.profile_photo_url" :alt="user.name">
    </div>

    <div class="whitespace-nowrap overflow-hidden text-sm">
        {{ user.name }}
    </div>
</template>

<script setup>
defineProps({
    user: {
        type: Object,
        required: true
    }
})
</script>
