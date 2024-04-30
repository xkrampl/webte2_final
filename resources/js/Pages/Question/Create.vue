<script setup>
import {useForm} from '@inertiajs/vue3'
import {computed} from "vue";

const props = defineProps({
    subjects: Object
})

const subjects = computed(() => props.subjects)

const form = useForm({
    description: null,
    subject: null
})
const create = () => form.post(route('question.store'))
</script>

<template>
    <h2>Create new question</h2>

    <form @submit.prevent="create">
        <label for="description">Description</label>
        <input type="text" v-model="form.description">

        <select v-model="form.subject">
            <option v-for="subject in subjects" :key="subject.id">{{ subject.name }}</option>
        </select>

        <button type="submit">Submit</button>
    </form>
</template>
