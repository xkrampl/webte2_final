<script setup>
defineProps({
    message: String,
})
</script>

<template>
    <main>
        <h2>Votes</h2>

        {{ message }}

        <p>{{ vote.description }}</p>
    </main>
</template>

<style scoped>
p {
    margin-top: 10px;
}
</style>
