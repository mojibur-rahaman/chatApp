<script setup>
import { defineProps } from "vue";
const props = defineProps({
    selectedUser: {
        type: Object,
        Required: true,
    },
});

const emit = defineEmits(["back"]);
const backToContact = () => {
    emit("back");
};
</script>
<template>
    <div class="flex justify-start items-center bg-blue-400 rounded-t-lg">
        <div class="relative px-4 py-2">
            <img
                :src="`/uploads/avatar/${selectedUser.avatar}`"
                alt="name"
                class="w-10 h-10 rounded-full"
            />
            <span
                :class="
                    selectedUser.onlineStatus ? 'bg-green-500' : 'bg-gray-500'
                "
                class="w-3 h-3 absolute border-2 border-gray-900 left-12 bottom-[8px] rounded-full"
            ></span>
        </div>
        <div class="flex justify-between items-center w-full">
            <div class="inline-flex flex-col">
                <span class="text-md font-medium">{{ selectedUser.name }}</span>
                <span class="text-[12px] font-medium text-gray-300"
                    >Active 7m ago</span
                >
            </div>
            <div
                @click="backToContact"
                class="block md:hidden animate-bounce w-10 h-full mr-4 rounded-full"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6 hover:text-white"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18"
                    />
                </svg>
            </div>
        </div>
    </div>
</template>
