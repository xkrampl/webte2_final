<template>
    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md mt-12">
        <h2 class="text-2xl font-semibold mb-4">{{ __('Create new question') }}</h2>

        <form @submit.prevent="create">
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                <input type="text" v-model="form.description" id="description" name="description" class="input-field">
            </div>

            <div class="mb-4">
                <label for="subject" class="block text-sm font-medium text-gray-700">{{ __('Subject') }}</label>
                <select v-model="form.subject" id="subject" name="subject" class="input-field">
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
                <select v-model="form.subjectType" id="subjectType" name="subjectType" @change="handleSubjectTypeChange"
                        class="input-field">
                    <option value="opened">{{ __('Opened') }}</option>
                    <option value="answers">{{ __('With Answers') }}</option>
                </select>
            </div>

            <!-- Display additional fields for answers -->
            <div v-if="form.subjectType === 'answers'">
                <label for="numberOfAnswers" class="block text-sm font-medium text-gray-700">{{
                        __('Number of Answers')
                    }}</label>
                <select v-model="form.numberOfAnswers" id="numberOfAnswers" name="numberOfAnswers" class="input-field">
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
import {computed} from "vue";
import {route} from "ziggy-js";

const props = defineProps({
    subjects: Object
})

const subjects = computed(() => props.subjects)

const form = useForm({
    description: null,
    subject: null,
    subjectType: 'opened', // Default value for subject type
    numberOfAnswers: '2', // Default value for number of answers
    answers: ['', ''], // Initialize answers array with empty strings
    correctAnswers: [0, 0] // Initialize correctAnswers array with 0 values

})

const create = () => form.post(route('question.store'))

const handleSubjectTypeChange = () => {
    // Reset answers array when subject type changes
    if (form.subjectType !== 'answers') {
        form.answers = Array.from({length: parseInt(form.numberOfAnswers)}, () => '');
    }
}
</script>

<style scoped>
.input-field {
    border: 1px solid #e2e8f0;
    border-radius: 0.25rem;
    padding: 0.5rem;
    width: 100%;
    transition: border-color 0.2s ease;
}

.input-field:focus {
    outline: none;
    border-color: #6366f1;
}

.form-checkbox {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 1rem;
    height: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 0.25rem;
    outline: none;
    cursor: pointer;
    transition: border-color 0.2s ease;
}

.form-checkbox:checked {
    border-color: #6366f1;
}

.form-checkbox:focus {
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.5);
}
</style>

