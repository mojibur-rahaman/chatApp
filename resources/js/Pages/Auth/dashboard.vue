<script setup>
import ChatMessage from "../components/chatMessage.vue";
import ChatsHeader from "../components/chatsHeader.vue";
import ChatsInput from "../components/chatsInput.vue";
import contactList from "../components/contactList.vue";
import { ref, computed, defineProps, watch, onMounted, nextTick } from "vue";
import { usePage, router } from "@inertiajs/vue3";

onMounted(() => {
    window.Echo.private(`chat-channel.${currentUserId}`).listen(
        "sendMessage",
        (event) => {
            messages.value.push(event.message);
            playSound();
            scrollToBottom();
        }
    );

    // Listen for presence updates on a shared channel for online/offline users
    window.Echo.join("online-users")
        .here((onlineUsers) => {
            // Set OnlineStatus to true for all users currently online
            users.value.forEach((user) => {
                user.onlineStatus = onlineUsers.some(
                    (onlineUser) => onlineUser.id === user.id
                );
            });
        })
        .joining((user) => {
            // When a user comes online, update their OnlineStatus
            const index = users.value.findIndex((u) => u.id === user.id);
            if (index !== -1) {
                users.value[index].onlineStatus = true;
            }
        })
        .leaving((user) => {
            // When a user goes offline, update their OnlineStatus
            const index = users.value.findIndex((u) => u.id === user.id);
            if (index !== -1) {
                users.value[index].onlineStatus = false;
            }
        });
});

// Mock current logged-in user id
const page = usePage();
const currentUserId = page.props.auth.user.id;

// Define props
const props = defineProps({
    contacts: {
        type: Array,
        required: true,
    },
    chats: {
        type: Array,
        required: true,
    },
});

// Reactive state
const users = ref(
    props.contacts.map((user) => ({ ...user, onlineStatus: false }))
);
const messages = ref([...props.chats]); // Initialize messages as a copy of props.chats
const selectedUser = ref(null); // To store the selected user

// Reference to the chat body for scrolling
const chatBody = ref(null);

// Scroll to the bottom of the chat body
const scrollToBottom = () => {
    nextTick(() => {
        if (chatBody.value) {
            chatBody.value.scrollTop = chatBody.value.scrollHeight;
        }
    });
};
// Watch for changes in selectedUser and fetch relevant chats
watch(selectedUser, (user) => {
    if (user) {
        router.get("/dashboard", { chat: user.id }, { preserveState: true });
        scrollToBottom(); // Scroll to bottom when a new chat is selected
    }
});

// Watch for changes in props.chats and update messages
watch(
    () => props.chats,
    (newChats) => {
        messages.value = [...newChats];
        scrollToBottom(); // Scroll to bottom when new chats are loaded
    },
    { deep: true }
);

// Handle selected user from contactList component
const handelSelectedUser = (user) => {
    selectedUser.value = user;
    mobileScreen.value = false;
};

// Handle messageData from chatInput Component
const handelSendMessage = (messageData) => {
    if (messageData && selectedUser.value) {
        let chatData = {
            sender_id: currentUserId,
            reciver_id: selectedUser.value.id,
            message: messageData.text,
        };
        messages.value.push(chatData); // Push the new message to the local messages array
        scrollToBottom(); // Scroll to bottom after sending a message
        router.post("/dashboard", chatData, {
            preserveState: true,
            replace: true,
        });
    }
};

// Filter messages by selected user and logged-in user
const filteredMessages = computed(() => {
    if (selectedUser.value) {
        return messages.value.filter(
            (chat) =>
                (chat.sender_id === currentUserId &&
                    chat.reciver_id === selectedUser.value.id) ||
                (chat.sender_id === selectedUser.value.id &&
                    chat.reciver_id === currentUserId)
        );
    }
    return [];
});

// Mobile Friendly ui
const mobileScreen = ref(true);

// Message Notification sound
const notiSound = new Audio("/sounds/1.wav");
const playSound = () => {
    notiSound.play();
};
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4">
        <!-- Contact List -->
        <div
            class="col-span-1"
            :class="{
                'block md:block': true,
                'hidden md:block': selectedUser && !mobileScreen,
            }"
        >
            <div class="flex flex-col h-screen p-2 bg-gray-100">
                <!-- Contacts Header -->
                <div class="bg-green-500 text-white p-3 rounded-t-lg shadow">
                    <h2 class="text-lg font-semibold">Contacts</h2>
                </div>
                <!-- Contacts Body -->
                <contactList
                    @click="mobileScreen = false"
                    :users="users"
                    @selectedUser="handelSelectedUser"
                />
            </div>
        </div>

        <!-- Chat Section -->
        <div
            class="col-span-1 md:col-span-2 xl:col-span-3"
            :class="{
                'hidden md:block': mobileScreen,
                'block md:block': !selectedUser && mobileScreen,
            }"
        >
            <div v-if="selectedUser" class="flex flex-col h-screen p-2 md:pl-0">
                <!-- Chats Header -->
                <ChatsHeader
                    :selectedUser="selectedUser"
                    @back="mobileScreen = true"
                />

                <!-- Messages List -->
                <div ref="chatBody" class="flex-1 overflow-y-auto">
                    <ChatMessage
                        :chats="filteredMessages"
                        :currentUserId="currentUserId"
                        :users="users"
                        :selectedUser="selectedUser"
                    />
                </div>

                <!-- Chat Input -->
                <ChatsInput @sendedMessage="handelSendMessage" />
            </div>

            <!-- Message area when no user is selected -->
            <div
                v-else
                class="flex items-center justify-center h-full p-4 bg-gray-100"
            >
                <h2 class="text-lg text-gray-600">
                    Select a contact to start chatting
                </h2>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
