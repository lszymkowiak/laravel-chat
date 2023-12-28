<template>
    <div class="relative w-80 h-12">
        <div class="absolute inset-x-0 bottom-0 bg-white overflow-clip" :class="[isMaximized ? 'rounded-md' : 'rounded-full']">
            <div class="flex items-center p-2 relative group" :class="{'animate-pulse bg-cyan-400': hasUnreadMessages, 'rounded-full': !isMaximized}">
                <chat-user :user="chat.user" :present="props.present"/>

                <div class="absolute right-1 p-1 flex space-x-2">
                    <button type="button" class="hidden group-hover:block hover:text-blue-500" @click="isMaximized = !isMaximized">
                        <chevron-down-icon v-if="isMaximized" class="size-4"/>
                        <chevron-up-icon v-else class="size-4"/>
                    </button>

                    <button type="button" class="hidden group-hover:block hover:text-red-500" @click="emit('close')">
                        <x-mark-icon class="size-4"/>
                    </button>
                </div>
            </div>

            <div v-show="isMaximized" class="border-t relative">
                <svg v-if="loading" class="absolute top-2 right-6 animate-spin h-5 w-5 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                </svg>

                <div ref="messageListDiv" class="h-96 p-2 space-y-2 overflow-y-auto">
                    <div v-for="(message, messageIdx) in chat.messages" :key="messageIdx" class="p-2 rounded-md text-sm" :class="[message.from_user_id === user.id ? 'bg-cyan-200 ml-8' : 'bg-gray-100 mr-8']">
                        <span v-html="message.content"/>
                        <div class="text-xs text-gray-500 text-right">
                            {{ message.date }}
                        </div>
                    </div>
                </div>

                <button v-if="hasUnreadMessages" class="animate-bounce bg-cyan-400 rounded-full text-white absolute right-5 bottom-12 p-2" @click="scrollToBottom">
                    <arrow-down-icon class="size-4"/>
                </button>

                <div class="border-t">
                    <textarea v-model="messageContent" class="w-full border-0 resize-none" rows="1" placeholder="Wiadomość..." @keydown.enter="sendMessage"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import ChatUser from "@/chat/ChatUser.vue";
import {XMarkIcon, ChevronDownIcon, ChevronUpIcon, ArrowDownIcon} from "@heroicons/vue/16/solid/index.js";
import {nextTick, onMounted, ref, watch} from "vue";

const emit = defineEmits(['close']);

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    chat: {
        type: Object,
        required: true
    },
    present: {
        type: Array,
        default: () => []
    }
})

const messageContent = ref('')
const messageListDiv = ref(null)
const isMaximized = ref(true)
const hasUnreadMessages = ref(false)
const loading = ref(false)

watch(props.chat.messages, (value) => {
    if (value[value.length - 1].from_user_id !== props.chat.user.id) {
        return
    }

    hasUnreadMessages.value = true
    if (messageListDiv.value.scrollHeight === messageListDiv.value.clientHeight) {
        setTimeout(() => hasUnreadMessages.value = false, 5000)
    }
})

onMounted(() => {
    scrollToBottom()

    messageListDiv.value.addEventListener('scroll', () => {
        let scroll = messageListDiv.value.scrollTop / (messageListDiv.value.scrollHeight - messageListDiv.value.clientHeight)

        if (scroll === 1) {
            hasUnreadMessages.value = false
        } else if (scroll === 0) {
            fetchData()
        }
    });
});

const sendMessage = (event) => {
    if (event.shiftKey) {
        return;
    }

    if (! messageContent.value.trim().length) {
        return;
    }

    axios.put(route('chat.store'), {
        to_user_id: props.chat.user.id,
        message_content: messageContent.value.trim()
    }).then(response => {
        messageContent.value = null
        props.chat.messages.push(response.data)
        scrollToBottom()
    })
}

const fetchData = () => {
    if (loading.value === true) {
        return
    }
    loading.value = true
    let sh = messageListDiv.value.scrollHeight
    axios.get(route('chat.show', [props.chat.user.id, props.chat.messages[0].id]))
        .then(response => {
            props.chat.messages = response.data.messages.concat(props.chat.messages);
            loading.value = false
            nextTick().then(() => messageListDiv.value.scrollTop = messageListDiv.value.scrollHeight - sh)

        })
}

const scrollToBottom = () => nextTick().then(() => messageListDiv.value.scrollTo(0, messageListDiv.value.scrollHeight));
</script>
