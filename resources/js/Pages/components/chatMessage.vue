<script setup>
import { defineProps } from "vue";
import { usePage } from "@inertiajs/vue3";
const props = defineProps({
    chats: {
        type: Array,
        Required: true,
    },
    currentUserId: {
        type: Number,
        Required: true,
    },
    users: {
        type: Array,
        Required: true,
    },
    selectedUser: {
        type: Object,
        Required: true,
    },
});

// Mock current logged-in user id
const page = usePage();
</script>
<template>
    <div class="flex-1 overflow-y-auto p-4 bg-gray-900">
        <!-- Chats User Info-->
        <div class="bg-gray-900 flex flex-col items-center">
            <div class="relative px-4 py-2">
                <img
                    :src="`/uploads/avatar/${selectedUser.avatar}`"
                    alt="name"
                    class="w-28 h-28 rounded-full border border-white/50"
                />
                <span
                    :class="
                        selectedUser.onlineStatus
                            ? 'bg-green-500'
                            : 'bg-gray-500'
                    "
                    class="w-4 h-4 absolute border-2 border-gray-900 left-24 bottom-[8px] rounded-full"
                ></span>
            </div>

            <span class="text-lg font-medium text-white">{{
                selectedUser.name
            }}</span>
            <span class="text-sm my-12 font-medium text-white/50"
                >Your are now connect to itthadi chats</span
            >
        </div>
        <!-- sended messages-->
        <div v-for="chat in chats" :key="chat.id" class="mb-4">
            <div
                class="flex items-start gap-2.5"
                :class="
                    chat.sender_id === currentUserId
                        ? 'flex-row-reverse'
                        : 'justify-start'
                "
            >
                <img
                    class="w-8 h-8 rounded-full"
                    :src="
                        chat.sender_id === currentUserId
                            ? `/uploads/avatar/${page.props.auth.user.avatar}`
                            : `/uploads/avatar/${selectedUser.avatar}`
                    "
                    :alt="selectedUser.name"
                />
                <div
                    class="w-fit max-w-[320px] p-4"
                    :class="
                        chat.sender_id === currentUserId
                            ? 'bg-blue-300 rounded-l-lg rounded-br-lg'
                            : 'bg-gray-100 rounded-r-lg rounded-bl-lg'
                    "
                >
                    <p class="text-sm font-normal">
                        {{ chat.message }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
