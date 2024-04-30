<script setup>
import { useForm, router } from '@inertiajs/vue3'
const form = useForm({
    question: null,
})

const showQuestion = () => router.get(route('question.show', form.question))
</script>

<template>
    <h1 class="font-bold text-blue-500">homepage</h1>

    <form @submit.prevent="showQuestion">
        <input type="text" v-model="form.question">
        <button type="submit">Zobrazit</button>
    </form>
</template>
