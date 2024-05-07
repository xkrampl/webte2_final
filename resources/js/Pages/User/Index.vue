<script setup>
import {computed} from "vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    questions: Object,
    filters: Object
})

const questions = computed(() => props.questions)

const filterForm = useForm({
    created_at: props.filters.created_at ?? null,
    subject: props.filters.subject ?? null,
})

const filter = () => {
    filterForm.get(route('user.question.index'), {
        preserveState: true,
        preserveScroll: true
    })
}

const clear = () => {
    filterForm.created_at = null
    filterForm.subject = null
    filter()
}
</script>

<template>

</template>

<style scoped>

</style>
