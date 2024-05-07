<template>
    <div class="p-6 bg-white rounded-lg shadow-lg max-w-md mx-auto mt-12">
        <h1 class="text-2xl font-bold text-center text-blue-600">Votes</h1>
        <form @submit.prevent="showQuestion" class="space-y-4">
            <div>
                <label for="question" class="block text-sm font-medium text-gray-700">Enter a question ID:</label>
                <input type="text" id="question" v-model="form.question"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       placeholder="ID is a 5 letter code">
            </div>
            <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Show Question
            </button>
        </form>
        <button @click="isModalOpen = true"
                class="mt-8 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            Open User Manual
        </button>
        <!-- Modal Section -->
        <transition name="fade">
            <div v-if="isModalOpen" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3 text-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">User Manual</h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500">
                                Here you can provide instructions or any other information needed. Explain how to use
                                the application, provide FAQ, etc.
                            </p>
                        </div>
                        <div class="items-center px-4 py-3">
                            <button @click="isModalOpen = false"
                                    class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import {ref} from 'vue';
import {router, useForm} from '@inertiajs/vue3'
import {route} from "ziggy-js";

const form = useForm({
    question: null,
})
const isModalOpen = ref(false);

const showQuestion = () => router.get(route('question.show', form.question))
</script>
