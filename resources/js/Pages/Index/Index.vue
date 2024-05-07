<template>
    <div class="p-6 bg-white rounded-lg shadow-lg max-w-md mx-auto mt-12">
        <h1 class="text-2xl font-bold text-center text-blue-600">
            {{ __('Votes') }}
        </h1>
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
    </div>
</template>

<script setup>
import {router, useForm} from '@inertiajs/vue3'
import {route} from "ziggy-js";

const form = useForm({
    question: null,
})

const showQuestion = () => router.get(route('question.show', form.question))
</script>
