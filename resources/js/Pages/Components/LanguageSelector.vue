<template>
    <div class="relative inline-block text-sm">
        <!-- Toggle button -->
        <button @click="toggleLanguage"
                class="bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg px-4 py-2 transition-colors duration-300">
            {{ otherLanguage.toUpperCase() }}
        </button>
    </div>
</template>

<script setup>
import {computed, ref} from "vue";
import {usePage} from '@inertiajs/vue3';
import {route} from "ziggy-js";

const page = usePage();
const currentLanguage = ref(page.props.locale);

// Computed property to determine which language to switch to
const otherLanguage = computed(() => currentLanguage.value === 'en' ? 'sk' : 'en');

function toggleLanguage() {
    // Assuming `route` is defined correctly in your environment to switch languages
    const newLangRoute = route('language', {language: otherLanguage.value});
    window.location.href = newLangRoute; // Redirect to switch language
}
</script>
