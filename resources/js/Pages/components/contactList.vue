<script setup>
import { defineProps, defineEmits } from "vue";
const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["selectedUser"]);

const selectUser = (user) => {
    emit("selectedUser", user);
};

// Helper function to construct the image path correctly
const filePath = (image) => {
    return `/uploads/avatar/${image}`;
};
</script>

<template>
    <div
        class="flex-1 overflow-y-auto h-full bg-black text-white p-4 rounded-b-lg shadow"
    >
        <ul>
            <li
                v-for="user in users"
                :key="user.id"
                class="w-full p-2 rounded-lg mb-2 hover:bg-gray-700 cursor-pointer"
                @click="selectUser(user)"
            >
                <div class="flex justify-start items-center">
                    <div class="relative">
                        <img
                            :src="filePath(user.avatar)"
                            :alt="user.name"
                            class="w-10 h-10 rounded-full mr-4"
                        />
                        <span
                            class="w-3 h-3 absolute border-2 border-gray-900 left-8 bottom-[2px] rounded-full"
                            :class="
                                user.onlineStatus
                                    ? 'bg-green-500'
                                    : 'bg-gray-500'
                            "
                        ></span>
                    </div>
                    <span class="text-sm font-medium">{{ user.name }}</span>
                </div>
            </li>
        </ul>
    </div>
</template>
