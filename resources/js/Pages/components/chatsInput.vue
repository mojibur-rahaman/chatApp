<script setup>
import { ref } from "vue";
const newMessage = ref("");
const emit = defineEmits(["sendedMessage"]);
const sendMessage = () => {
    if (newMessage.value.trim() !== "") {
        // Message Data send to parent component
        const messageData = {
            text: newMessage.value,
        };
        emit("sendedMessage", messageData);
        newMessage.value = ""; // Clear the input
    }
};
</script>
<template>
    <div class="mt-4 flex">
        <input
            v-model="newMessage"
            @keyup.enter="sendMessage"
            type="text"
            placeholder="Type your message"
            class="flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
        />
        <button
            @click="sendMessage"
            class="ml-2 bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors"
        >
            Send
        </button>
    </div>
</template>
