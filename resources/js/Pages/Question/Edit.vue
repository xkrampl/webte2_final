<template>
    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md mt-12">
        <h2 class="text-2xl font-semibold mb-4">{{ __('Edit existing question') }}</h2>

        <form @submit.prevent="edit">
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                <input type="text" v-model="form.description" id="description" name="description" class="input-field">
            </div>

            <div class="mb-4">
                <label for="subject" class="block text-sm font-medium text-gray-700">{{ __('Subject') }}</label>
                <select v-model="form.subject_id" id="subject" name="subject" class="input-field">
                    <option v-for="subject in subjects" :key="subject.id" :value="subject.id">{{
                            subject.name
                        }}
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <label for="subjectType" class="block text-sm font-medium text-gray-700">{{
                        __('Question Type')
                    }}</label>
                <select v-model="form.type" @change="handleSubjectTypeChange" class="input-field">
                    <option value="opened">{{ __('Opened') }}</option>
                    <option value="answers">{{ __('With Answers') }}</option>
                </select>
            </div>

            <!-- Display additional fields for answers -->
            <div v-if="form.type === 'answers'">
                <label for="numberOfAnswers" class="block text-sm font-medium text-gray-700">{{
                        __('Number of Answers')
                    }}</label>
                <select v-model="form.numberOfAnswers" id="numberOfAnswers" name="numberOfAnswers" class="input-field">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>

                <template v-for="index in parseInt(form.numberOfAnswers)" :key="index">
                    <div class="mt-4">
                        <label :for="'answer' + index" class="block text-sm font-medium text-gray-700">
                            {{ __('Answer') }} {{
                                index
                            }}</label>
                        <input type="text" v-model="form.answers[index - 1]" :id="'answer' + index"
                               :name="'answer' + index" class="input-field">

                        <!-- Checkbox for marking as correct or false -->
                        <label class="inline-flex items-center mt-2">
                            <input type="checkbox" v-model="form.correctAnswers[index - 1]"
                                   class="form-checkbox h-5 w-5 text-indigo-600">
                            <span class="ml-2 text-gray-700">{{ __('Correct answer') }}</span>
                        </label>
                    </div>
                </template>
            </div>

            <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
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
    subject_id: question.value.subject.id ?? null,
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
