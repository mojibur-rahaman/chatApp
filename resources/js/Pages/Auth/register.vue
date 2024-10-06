<script setup>
import { useForm } from "@inertiajs/vue3";
import inputText from "../components/inputText.vue";

const form = useForm({
    avatar: null,
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    preview: null,
});

const change = (e) => {
    (form.avatar = e.target.files[0]),
        (form.preview = URL.createObjectURL(e.target.files[0]));
};

const submit = () => {
    form.post("/register");
};
</script>
<template>
    <Head title="| Register" />
    <div class="w-full md:w-1/2 lg:w-1/3 mx-auto bg-white rounded-lg">
        <div class="p-4 mt-16">
            <form @submit.prevent="submit" class="max-w-sm mx-auto">
                <div class="flex items-center justify-center w-full">
                    <label
                        for="dropzone-file"
                        class="relative flex flex-col items-center justify-center w-24 h-24 border-2 border-gray-300 border-dashed rounded-full cursor-pointer"
                    >
                        <img
                            class="object-cover w-24 h-24 rounded-full"
                            :src="
                                form.preview ??
                                'https://randomuser.me/api/portraits/men/85.jpg'
                            "
                            alt="Profile"
                        />
                        <div
                            class="absolute inline-flex justify-center items-center w-12 h-12 rounded-full -bottom-3 -right-4 border-2 text-gray-300 bg-gray-500"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 4.5v15m7.5-7.5h-15"
                                />
                            </svg>
                        </div>
                        <input
                            id="dropzone-file"
                            @input="change"
                            type="file"
                            class="hidden"
                        />
                    </label>
                </div>

                <inputText
                    name="Your Name"
                    v-model="form.name"
                    :message="form.errors.name"
                    placeholder="Jhon Doe"
                />
                <inputText
                    name="Your Email"
                    type="email"
                    v-model="form.email"
                    :message="form.errors.email"
                    placeholder="Enter Your Email Address"
                />
                <inputText
                    name="Your Password"
                    type="password"
                    v-model="form.password"
                    :message="form.errors.password"
                    placeholder="password"
                />
                <inputText
                    name="Your Conform Password"
                    type="password"
                    v-model="form.password_confirmation"
                    placeholder="conform password"
                />

                <button
                    type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    Submit
                </button>
            </form>
        </div>
    </div>
</template>
