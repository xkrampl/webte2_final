<template>
    <div class="max-w-2xl mx-auto p-8 bg-white rounded-lg shadow-lg mt-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ __('Edit existing question') }}</h2>

        <form @submit.prevent="edit" class="space-y-6">
            <div>
                <label for="description" class="block text-lg font-medium text-gray-800">{{ __('Description') }}</label>
                <input type="text" v-model="form.description" id="description" name="description"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <div v-if="form.errors.description" class="text-red-500 text-xs italic">
                    {{ form.errors.description }}
                </div>
            </div>

            <div>
                <label for="subject" class="block text-lg font-medium text-gray-800">{{ __('Subject') }}</label>
                <select v-model="form.subject" id="subject" name="subject"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option v-for="subject in subjects" :key="subject.id" :value="subject.id">{{
                            subject.name
                        }}
                    </option>
                </select>
            </div>

            <div>
                <label for="subjectType" class="block text-lg font-medium text-gray-800">{{
                        __('Question Type')
                    }}</label>
                <select v-model="form.type" @change="handleSubjectTypeChange"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="opened">{{ __('Opened') }}</option>
                    <option value="answers">{{ __('With Answers') }}</option>
                </select>
            </div>

            <!-- Display additional fields for answers -->
            <div v-if="form.type === 'answers'">
                <label for="numberOfAnswers" class="block text-lg font-medium text-gray-800">{{
                        __('Number of Answers')
                    }}</label>
                <select v-model="form.numberOfAnswers" id="numberOfAnswers" name="numberOfAnswers"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>

                <template v-for="index in parseInt(form.numberOfAnswers)" :key="index">
                    <div class="mt-6">
                        <label :for="'answer' + index" class="block text-lg font-medium text-gray-800">
                            {{ __('Answer') }} {{ index }}
                        </label>
                        <input type="text" v-model="form.answers[index - 1]" :id="'answer' + index"
                               :name="'answer' + index"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                        <!-- Displaying errors for each answer -->
                        <div v-if="form.errors.answers && form.errors.answers[index - 1]"
                             class="text-red-500 text-xs italic">
                            {{ form.errors.answers[index - 1] }}
                        </div>

                        <!-- Checkbox for marking as correct or false -->
                        <label class="inline-flex items-center mt-3">
                            <input type="checkbox" v-model="form.correctAnswers[index - 1]"
                                   class="form-checkbox h-5 w-5 text-indigo-600">
                            <span class="ml-2 text-gray-800">{{ __('Correct answer') }}</span>
                        </label>
                    </div>
                </template>
            </div>

            <button type="submit"
                    class="px-4 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                {{ __('Submit') }}
            </button>
        </form>
    </div>
</template>


<script setup>
import {useForm} from '@inertiajs/vue3'
import {computed, watch} from "vue"
import {route} from "ziggy-js"

const props = defineProps({
    question: Object,
    subjects: Object
})

const question = computed(() => props.question)
const subjects = computed(() => props.subjects)

const form = useForm({
    description: question.value.description ?? null,
    subject: question.value.subject.id ?? null,
    type: question.value.type ?? 'opened',
    numberOfAnswers: question.value.answers.length ?? 2,
    answers: question.value.answers.map(answer => answer.text),
    correctAnswers: question.value.answers.length ?
        question.value.answers.map(
            answer => answer.is_correct === 1
                ? true
                : (answer.is_correct === 0 ? false : null)).filter(value => value !== null)
        : []
})

const edit = () => form.put(route('question.update', question.value))

const handleSubjectTypeChange = () => {
    // Reset answers array when subject type changes
    if (form.type !== 'answers') {
        form.answers = Array.from({length: parseInt(form.numberOfAnswers)}, () => '')
    }
}

watch(() => form.numberOfAnswers, (newValue, oldValue) => {
    while (form.answers.length < newValue) {
        form.answers.push('')
    }

    while (form.answers.length > newValue) {
        form.answers.pop()
    }

    while (form.correctAnswers.length < newValue) {
        form.correctAnswers.push(false)
    }

    while (form.correctAnswers.length > newValue) {
        form.correctAnswers.pop()
    }
})
</script>

<style scoped>

</style>
