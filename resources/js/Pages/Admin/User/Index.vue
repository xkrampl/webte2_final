<template>
    <div class="p-6 bg-gray-100 min-h-screen">
        <div v-for="user in users" :key="user.id" class="mb-8 bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-teal-500 p-4 text-white">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold">{{ user.name }} ({{ user.email }})</h2>
                    <div class="flex space-x-2">
                        <button @click="toggleQuestions(user.id)"
                                class="bg-gradient-to-r from-white to-gray-100 text-gray-800 py-1 px-4 rounded-lg hover:from-gray-200 hover:to-gray-300 transition duration-200 ease-in-out shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                            {{ activeUsers.includes(user.id) ? __('Hide Questions') : __('Show Questions') }}
                        </button>

                        <!-- Edit Button -->
                        <Link :href="route('admin.user.edit', user)" method="GET" as="button"
                              class="px-4 py-2 bg-green-500 text-white rounded-md font-semibold tracking-wide transition duration-300 ease-in-out hover:bg-green-600 shadow-md hover:shadow-xl">
                            {{ __('Edit') }}
                        </Link>

                        <!-- Delete Button -->
                        <Link v-if="!user.is_admin" :href="route('admin.user.destroy', user)" method="DELETE"
                              as="button"
                              class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg font-semibold tracking-wide transition duration-300 ease-in-out hover:from-red-600 hover:to-red-700 shadow-md hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
                            {{ __('Delete') }}
                        </Link>
                    </div>
                </div>
                <p v-if="user.is_admin" class="text-sm bg-red-700 px-2 py-1 inline-block rounded-full mt-2">
                    {{ __('Admin') }}
                </p>
            </div>

            <div v-show="activeUsers.includes(user.id)" class="p-4 space-y-2">
                <div v-for="question in user.questions" :key="question.id" class="p-3 bg-gray-50 rounded shadow-sm">
                    <p class="font-semibold">{{ question.description }}</p>
                    <p class="text-sm text-gray-600">{{ __('Status') }}: <span
                        :class="{'text-green-500': question.is_active, 'text-red-500': !question.is_active}">{{
                            __(question.type)
                        }}</span></p>
                    <p class="text-sm text-gray-600">{{ __('Active') }}: <span
                        :class="{'text-green-500': question.is_active, 'text-red-500': !question.is_active}">{{
                            question.is_active ? __('Yes') : __('No')
                        }}</span></p>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import {ref} from 'vue';
import {route} from "ziggy-js";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    users: Array
});

const activeUsers = ref([]);

const toggleQuestions = (userId) => {
    const index = activeUsers.value.indexOf(userId);
    if (index !== -1) {
        activeUsers.value.splice(index, 1);
    } else {
        activeUsers.value.push(userId);
    }
};
</script>

<style scoped>
/* Optionally, you can add some specific styles here if needed, or use Tailwind's utilities */
</style>
