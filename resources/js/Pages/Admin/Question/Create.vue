<script setup>
import {computed} from "vue";

const props = defineProps({
    subjects: Object,
    users: Object
})

const subjects = computed(() => props.subjects)
const users = computed(() => props.users)
</script>

<template>

</template>

<style scoped>

</style>
