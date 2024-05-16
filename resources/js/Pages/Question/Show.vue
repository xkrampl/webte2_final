<template>
    <div class="p-6 bg-white rounded-lg shadow-lg max-w-4xl mx-auto mt-12">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ __('Question') }}: {{ question.id }}</h2>
        <p class="text-gray-600 text-sm">{{ __('Description') }}: {{ question.description }}</p>
        <p class="text-gray-600 text-sm">{{ __('Subject') }}: {{ question.subject.name }}</p>

        <div v-html="qrcode"></div>

        <div class="mt-4">

            <form @submit.prevent="submit">
                <p v-if="question.type === 'answers'" class="text-gray-800 font-medium mb-4">{{
                        __('Choose your answer')
                    }}:</p>
                <div v-if="question.type === 'answers'" v-for="answer in question.answers" :key="answer.id"
                     :class="{'bg-green-200': isSubmitted && answer.is_correct, 'bg-red-200': isSubmitted && !answer.is_correct}">
                    <label class="flex items-center p-2">
                        <input type="checkbox" v-model="form.text" :value="answer.id" class="mr-2">
                        {{ answer.text }}
                    </label>
                </div>
                <div v-else-if="question.type === 'opened'">
                    <input type="text" v-model="userAnswer" class="p-2 border border-gray-300 rounded"
                           placeholder="Type your answer here...">
                </div>

                <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
                    {{ __('Submit') }}
                </button>
            </form>


            <div class="grid grid-cols-4 gap-4 mt-4 p-4 border-2 border-gray-300 rounded-lg shadow">
                <!-- Edit Button -->
                <Link :href="route('question.edit', question)" method="GET" as="button"
                      class="px-4 py-2 bg-green-500 text-white rounded-md font-semibold tracking-wide transition duration-300 ease-in-out hover:bg-green-600 shadow-md hover:shadow-xl">
                    {{ __('Edit') }}
                </Link>

                <!-- Duplicate Button -->
                <Link :href="route('question.duplicate', question)" method="POST" as="button"
                      class="px-4 py-2 bg-sky-500 text-white rounded-md font-semibold tracking-wide transition duration-300 ease-in-out hover:bg-sky-600 shadow-md hover:shadow-xl">
                    {{ __('Duplicate') }}
                </Link>

                <!-- Delete Button -->
                <Link :href="route('question.destroy', question)" method="DELETE" as="button"
                      class="px-4 py-2 bg-red-500 text-white rounded-md font-semibold tracking-wide transition duration-300 ease-in-out hover:bg-red-600 shadow-md hover:shadow-xl">
                    {{ __('Delete') }}
                </Link>

                <!-- Activate/Deactivate Button -->
                <Link :href="route('question.active', {question: question.id, active: !question.is_active})"
                      method="PUT"
                      as="button"
                      class="px-4 py-2 rounded-md font-semibold tracking-wide transition duration-300 ease-in-out shadow-md hover:shadow-xl"
                      :class="question.is_active ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-green-500 hover:bg-green-600 text-white'">
                    {{ question.is_active ? 'Deactivate' : 'Activate' }}
                </Link>
            </div>

            <!-- Archive -->
            <form @submit.prevent="archive" class="mt-4">
                <input v-model="formArchive.note" type="text"
                       class="px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit"
                        class="ml-4 px-4 py-2 rounded-md font-semibold tracking-wide transition duration-300 ease-in-out shadow-md hover:shadow-xl bg-blue-500 hover:bg-blue-600 text-white">
                    {{ __('Archive') }}
                </button>
            </form>

        </div>
    </div>
</template>

<script setup>
import {computed, defineProps, ref} from 'vue'
import {route} from "ziggy-js";
import {Link, useForm} from '@inertiajs/vue3'

const props = defineProps({
    question: Object,
    qrcode: String
})

const question = computed(() => props.question)
const selectedAnswers = ref([])
const userAnswer = ref('') // For 'opened' type questions
const isSubmitted = ref(false)


const submit = () => form.post(route('answer.store', {question: question.value}))

const submitAnswers = () => {
    isSubmitted.value = true;
    console.log('Selected Answers:', selectedAnswers.value);
    if (question.value.type === 'opened') {
        console.log('User answer:', userAnswer.value); // Handling user input for 'opened' type questions
        return userAnswer.value;
    }
    return selectedAnswers.value;
}

const form = useForm({
    text: selectedAnswers.value,
})

const formArchive = useForm({
    note: null,
})

const archive = () => formArchive.post(route('question.archive', question.value))
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
