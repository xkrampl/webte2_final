<template>
    <div class="p-6 bg-white rounded-lg shadow-lg max-w-2xl mx-auto mt-12">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Question: {{ question.id }}</h2>
        <p class="text-gray-600 text-sm">Description: {{ question.description }}</p>
        <p class="text-gray-600 text-sm">Subject: {{ question.subject.name }}</p>
        <div class="mt-4">
            <p v-if="question.type === 'answers'" class="text-gray-800 font-medium mb-4">Choose your answer:</p>
            <div v-if="question.type === 'answers'" v-for="answer in question.answers" :key="answer.id"
                 :class="{'bg-green-200': isSubmitted && answer.is_correct, 'bg-red-200': isSubmitted && !answer.is_correct}">
                <label class="flex items-center p-2">
                    <input type="checkbox" v-model="selectedAnswers" :value="answer.id" class="mr-2">
                    {{ answer.text }}
                </label>
            </div>
            <div v-else-if="question.type === 'opened'">
                <input type="text" v-model="userAnswer" class="p-2 border border-gray-300 rounded"
                       placeholder="Type your answer here...">
            </div>
            <button @click="submitAnswers" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
                Submit Answers
            </button>

            <Link :href="route('question.destroy', question)" method="DELETE" as="button">Delete</Link>
        </div>
    </div>
</template>

<script setup>
import {computed, defineProps, ref} from 'vue'
import {route} from "ziggy-js";
import {Link} from '@inertiajs/vue3'

const props = defineProps({
    question: Object
})

const question = computed(() => props.question)
const selectedAnswers = ref([])
const userAnswer = ref('') // For 'opened' type questions
const isSubmitted = ref(false)

const submitAnswers = () => {
    isSubmitted.value = true;
    console.log('Selected Answers:', selectedAnswers.value);
    if (question.value.type === 'opened') {
        console.log('User answer:', userAnswer.value); // Handling user input for 'opened' type questions
    }
}
</script>

<style scoped>
/* Scoped styles if needed */
.bg-red-200 {
    background-color: #fecaca;
}

.bg-green-200 {
    background-color: #bbf7d0;
}
</style>
