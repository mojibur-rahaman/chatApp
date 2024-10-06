<script setup>
import { defineProps } from "vue";
const props = defineProps({
    selectedUser: {
        type: Object,
        Required: true,
    },
});
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
        <div class="flex flex-col">
            <span class="text-md font-medium">{{ selectedUser.name }}</span>
            <span class="text-[12px] font-medium text-gray-300"
                >Active 7m ago</span
            >
        </div>
    </div>
</template>
