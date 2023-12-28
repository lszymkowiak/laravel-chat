<template>
    <div class="fixed bottom-0 right-0 flex p-4 flex-row-reverse items-center">
        <div class="relative">
            <button type="button" class="bg-white border rounded-full p-4" @click="usersShow = !usersShow">
                <chat-bubble-bottom-center-text-icon class="size-4"/>
            </button>

            <div v-if="usersShow" class="absolute bottom-14 right-0 bg-white border rounded-md w-80 z-10">
                <div class="h-64 overflow-y-auto overflow-x-clip p-2">
                    <div v-for="user in usersFiltered" :key="user.id" class="flex items-center hover:bg-gray-50 rounded-full p-2" role="button" :title="user.name" @click="startChat(user)">
                        <chat-user :user="user" :present="usersPresent"/>
                    </div>
                </div>

                <div class="border-t">
                    <input ref="usersSearchInput" v-model="usersSearch" type="search" class="w-full border-0" placeholder="Szukaj...">
                </div>
            </div>
        </div>

        <div class="flex space-x-4 mr-4" :class="{'opacity-25': usersShow}">
            <chat-message
                v-for="(chat, chatIdx) in chatList" :key="chat.user.id"
                :user="page.props.auth.user"
                :chat="chat"
                :present="usersPresent"
                @close="closeChat(chatIdx, chat.user.id)"
            />
        </div>
    </div>
</template>

<script setup>
import {ChatBubbleBottomCenterTextIcon} from "@heroicons/vue/24/outline/index.js";
import {computed, onMounted, ref, watch} from "vue";
import { usePage } from '@inertiajs/vue3';
import ChatUser from "@/chat/ChatUser.vue";
import ChatMessage from "@/chat/ChatMessage.vue";

const page = usePage();
const usersList = ref([]);
const usersShow = ref(false)
const usersSearch = ref('')
const usersSearchInput = ref(null)
const usersPresent = ref([])
const chatList = ref([])

const usersFiltered = computed(() => {
    return usersSearch.value.length > 0
        ? usersList.value.filter(item => item.name.toLowerCase().includes(usersSearch.value.toLowerCase()))
        : usersList.value
})

watch(usersShow, (value) => {
    if (value === true) {
        setTimeout(() => usersSearchInput.value.focus(), 250);
    }
})

onMounted(() => {
    fetchData()
    watchPresence()
    watchChat()
})

const fetchData = () => {
    axios.get(route('chat.index'))
        .then(response => {
            usersList.value = response.data.users
            response.data.chats.forEach(item => {
                chatList.value.push({
                    user: item.interlocutor,
                    messages: item.messages
                })
            })
        })
}

const startChat = (user) => {
    if (getChatIdx(user.id)) {
        return
    }

    usersShow.value = false

    axios.get(route('chat.show', user.id))
        .then(response => {
            chatList.value.push({
                user: user,
                messages: response.data.messages
            })
        })

    return chatList.value.length - 1
}

const closeChat = (idx, userId) => {
    axios.delete(route('chat.destroy', userId))
        .then(() => chatList.value.splice(idx, 1))
}

const getChatIdx = (id) => {
    let chatIdx = null

    chatList.value.forEach((item, idx) => {
        if (item.user.id === id) {
            chatIdx = idx
        }
    })

    return chatIdx
}

const watchPresence = () => {
    Echo.join('chat')
        .here((users) => {
            usersPresent.value = users
        })
        .joining((user) => {
            usersPresent.value.push(user)
        })
        .leaving((user) => {
            let idx = usersPresent.value.findIndex(item => item.id === user.id)
            if (idx >= 0) {
                usersPresent.value.splice(idx, 1)
            }

        })
}

const watchChat = () => {
    Echo.private(`chat.${page.props.auth.user.id}`)
        .listen('ChatMessageEvent', (e) => {
            onChatMessage(e)
        })
}

const onChatMessage = (e) => {
    let chatIdx = getChatIdx(e.user.id)

    if (chatIdx === null) {
        chatIdx = startChat(e.user)
    }

    chatList.value[chatIdx].messages.push(e.message)
}
</script>
