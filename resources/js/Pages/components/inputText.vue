<script setup>
const model = defineModel({ type: null, require: true });
defineProps({
    name: {
        text: String,
        require: true,
    },
    type: {
        type: String,
        default: "text",
    },
    message: String,
    placeholder: {
        type: String,
    },
});
</script>
<template>
    <div class="mb-5">
        <label
            for="name"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >{{ name }}</label
        >
        <input
            v-model="model"
            :type="type"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            :placeholder="placeholder"
            :class="{ 'border-red-500': message }"
        />
        <span class="text-red-500" v-if="message">{{ message }}</span>
    </div>
</template>
