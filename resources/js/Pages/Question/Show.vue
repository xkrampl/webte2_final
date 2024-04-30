<script setup>
import {computed} from 'vue'

const props = defineProps({
    question: Object
})

const question = computed(() => props.question)
</script>

<template>
    <h2>Question: {{ question.description }}</h2>
</template>

<style scoped>

</style>
