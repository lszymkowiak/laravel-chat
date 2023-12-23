<template>
    <div class="fixed bottom-0 right-0 flex p-4 flex-row-reverse">
        <div class="relative">
            <button type="button" class="bg-white border rounded-full p-3" @click="usersShow = !usersShow">
                <chat-bubble-bottom-center-icon class="size-4"/>
            </button>

            <!-- TODO: transition -->
            <div v-if="usersShow" class="absolute bottom-12 right-0 bg-white border rounded-md w-64 z-10">
                <div class="h-64 overflow-y-auto overflow-x-clip p-2">
                    <div v-for="user in usersFiltered" :key="user.id" class="flex items-center hover:bg-gray-50 rounded-full p-2" role="button" :title="user.name" @click="startChat(user)">
                        <chat-user :user="user"/>
                    </div>
                </div>

                <div class="border-t">
                    <input ref="usersSearchInput" v-model="usersSearch" type="search" class="w-full border-0" placeholder="Szukaj...">
                </div>
            </div>
        </div>

        <div class="flex space-x-2 mr-2">
            <div v-for="(chat, chatIdx) in chatList" :key="chatIdx" class="relative w-64">
                <div class="absolute inset-x-0 bottom-0 bg-white rounded-md">
                    <div class="flex items-center bg-white border-b p-2 relative group">
                        <chat-user :user="chat.user"/>

                        <button type="button" class="absolute right-1 p-1 rounded-full hidden group-hover:block hover:text-red-500" @click="closeChat(chatIdx, chat.user.id)">
                            <x-mark-icon class="size-4"/>
                        </button>
                    </div>

                    <chat-message :messages="chat.messages"/>

                    <div class="border-t">
                        <input ref="usersSearchInput" v-model="usersSearch" type="search" class="w-full border-0" placeholder="Wiadomość...">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ChatBubbleBottomCenterIcon, XMarkIcon} from "@heroicons/vue/16/solid/index.js";
import {computed, onMounted, ref, watch} from "vue";
import { usePage } from '@inertiajs/vue3';
import ChatUser from "@/chat/ChatUser.vue";
import ChatMessage from "@/chat/ChatMessage.vue";

const page = usePage();
const usersList = ref([]);
const usersShow = ref(false)
const usersSearch = ref('')
const usersSearchInput = ref(null)
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
    // watchPresence()
    watchChat()
})

const fetchData = () => {
    axios.get(route('chat.index'))
        .then(response => {
            usersList.value = response.data.users
            response.data.chats.forEach(item => {
                chatList.value.push({
                    user: item.interlocutor,
                    messages: []
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

const closeChat = (index, userId) => {
    axios.delete(route('chat.destroy', userId))
        .then(() => chatList.value.splice(index, 1))
}

const getChatIdx = (id) => {
    let isOpen = null

    chatList.value.forEach((item, idx) => {
        if (item.user.id === id) {
            isOpen = idx
        }
    })

    return isOpen
}

// const watchPresence = () => {
//     Echo.join('chat')
//         .here((users) => {
//             console.log(users)
//         })
//         .joining((user) => {
//             console.log(user.name);
//         })
//         .leaving((user) => {
//             console.log(user.name);
//         })
//         .error((error) => {
//             console.error(error);
//         });
// }

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
