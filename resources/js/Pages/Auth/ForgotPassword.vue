<template>
    <form @submit.prevent="send" class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md mt-12">
        <div class="w-full max-w-sm mx-auto">
            <div>
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">{{ __('E-mail') }}</label>
                <input id="email" v-model="form.email" type="text"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                <div v-if="form.errors.email" class="text-red-500 text-xs italic">{{ form.errors.email }}</div>
            </div>

            <div class="mt-4">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                    type="submit">{{ __('Send') }}
                </button>

            </div>
        </div>
    </form>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3'
import {route} from "ziggy-js";

const form = useForm({
    email: null,
})
const send = () => form.post(route('forgot-password.store'))
</script>
