<template>
    <div class="shrink-0 mr-2">
        <img class="size-8 rounded-full object-cover" :src="user.profile_photo_url" :alt="user.name">
    </div>

    <div v-if="isPresent" class="h-2 w-2 bg-green-500 rounded-full mr-2"/>

    <div class="whitespace-nowrap overflow-hidden text-sm">
        {{ user.name }}
    </div>
</template>

<script setup>
import {computed} from "vue";

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    present: {
        type: Array,
        default: () => []
    }
})

const isPresent = computed(() => props.present.findIndex(item => item.id === props.user.id) >= 0)
</script>
