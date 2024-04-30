<script setup>
import { useForm, Link } from '@inertiajs/vue3'
const form = useForm({
    description: null,
})
const create = () => form.post(route('question.store'))
</script>

<template>
    <h2>Create new question</h2>

    <form @submit.prevent="create">
        <label for="description">Description</label>
        <input type="text" v-model="form.description">

        <button type="submit">Submit</button>
    </form>
</template>
