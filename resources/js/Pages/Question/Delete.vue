<template>
    <button @click="deleteQuestion" class="px-4 ml-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">
        Delete Question
    </button>
</template>

<script setup>
import {defineProps, ref} from 'vue';
import {Inertia} from '@inertiajs/inertia';
import {route} from "ziggy-js";

const props = defineProps({
    questionId: String
});

const isLoading = ref(false);

const deleteQuestion = () => {
    if (window.confirm("Are you sure you want to delete this question?")) {
        isLoading.value = true;
        Inertia.delete(route('question.destroy', {question: props.questionId}), {
            preserveScroll: true,
            preserveState: true,
            onFinish: () => isLoading.value = false,
            onSuccess: () => {
                alert('Question deleted successfully!');
                // Redirect or update state as needed
            },
            onError: () => {
                alert('Failed to delete the question.');
            }
        });
    }
}
</script>
