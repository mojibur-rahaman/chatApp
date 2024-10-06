<script setup>
import { useForm } from "@inertiajs/vue3";
import inputText from "../components/inputText.vue";
const model = defineModel({ type: String });
const form = useForm({
    email: null,
    password: null,
    remember: null,
});
const submit = () => {
    form.post("/login");
};
</script>
<template>
    <Head title="| Login" />
    <div class="w-full md:w-1/2 lg:w-1/3 mx-auto bg-white rounded-lg">
        <div class="p-4 mt-16">
            <form @submit.prevent="submit" class="max-w-sm mx-auto">
                <inputText
                    name="Enter Your Email"
                    type="email"
                    v-model="form.email"
                    placeholder="Email Address"
                    :message="form.errors.email"
                />
                <inputText
                    name="Enter Your Password"
                    type="password"
                    v-model="form.password"
                    placeholder="Enter Password"
                    :message="form.errors.password"
                />
                <div class="mb-5 flex items-center">
                    <label
                        id="remember"
                        for="remember"
                        class="block mr-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Remember Me</label
                    >
                    <input v-model="form.remember" type="checkbox" />
                </div>
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
