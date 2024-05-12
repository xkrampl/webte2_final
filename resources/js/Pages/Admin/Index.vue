<script setup>
import {computed} from "vue";

const props = defineProps({
    questions: Object,
    filters: Object,
    subjects: Object,
    users: Object
})

const question = computed(() => props.questions)
const subjects = computed(() => props.subjects)
const users = computed(() => props.users)
</script>

<template>
Admin dashboard
</template>

<style scoped>

</style>
