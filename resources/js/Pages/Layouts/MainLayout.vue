<script setup>
import {usePage} from "@inertiajs/vue3";

const page = usePage()
</script>

<template>
    <main class="container max-w-screen-2xl mx-auto p-4">
        <slot />
    </main>
</template>
