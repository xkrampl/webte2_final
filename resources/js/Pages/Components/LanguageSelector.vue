<template>
    <div class="ml-4">
        <Link :href="route('language', language)">
            {{ language }}
        </Link>
    </div>
</template>

<script setup>
import {Link, usePage} from '@inertiajs/vue3'
import {computed} from "vue";

const page = usePage()
const language = computed(() => page.props.locale === 'en' ? 'sk' : 'en')

</script>
