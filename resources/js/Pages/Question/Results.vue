<template>
    <div class="max-w-2xl mx-auto py-8 px-4 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Results') }}</h2>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">{{ __('Answer Details') }}:</h3>
        <ul>
            <li v-for="(answer, index) in answers" :key="index"
                class="px-4 py-2 rounded-md hover:bg-gray-100 transition-colors"
                :class="{'bg-green-100 text-green-800': answer.is_correct, 'bg-red-100 text-red-800': !answer.is_correct}">
                <strong>{{ answer.id }}</strong>: {{ answer.text }} -
                <strong>{{ answer.is_correct ? 'Correct' : 'Incorrect' }}</strong>
            </li>
        </ul>
        <h3 class="text-xl font-semibold text-gray-700 mt-6 mb-2">{{ __('Summary') }}:</h3>
        <p class="text-lg text-gray-600">{{ __('Total Correct Answers') }}: {{ count_correct }}</p>
        <p class="text-lg text-gray-600">{{ __('Total Incorrect Answers') }}: {{ count_incorrect }}</p>
    </div>
</template>

<script setup>
import {defineProps} from 'vue';

const props = defineProps({
    answers: Array,
    count_correct: Number,
    count_incorrect: Number
});
</script>

<style scoped>
/* No additional CSS needed here if Tailwind CSS is fully used */
</style>
