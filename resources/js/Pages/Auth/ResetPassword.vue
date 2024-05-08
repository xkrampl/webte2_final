<template>
    <form @submit.prevent="resetPassword" class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="w-full max-w-lg p-8 space-y-6 bg-white shadow-lg rounded-xl">
            <h2 class="text-center text-2xl font-bold text-gray-700">{{ __('Reset Password') }}</h2>
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('E-mail') }}</label>
                    <input id="email" v-model="form.email" type="text"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/>
                    <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                    <input id="password" v-model="form.password" type="password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        {{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" v-model="form.password_confirmation" type="password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/>
                    <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</div>
                </div>
            </div>
            <button
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                type="submit">
                {{ __('Reset Password') }}
            </button>
            <div class="mt-2 text-center">
                <Link :href="route('homepage')" class="text-sm text-indigo-600 hover:text-indigo-800">
                    {{ __('Go back home.') }}
                </Link>
            </div>
        </div>
    </form>
</template>

<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import {route} from "ziggy-js";

const props = defineProps({
    token: String
})

const form = useForm({
    token: props.token,
    email: null,
    password: null,
    password_confirmation: null
})
const resetPassword = () => form.post(route('password.update'))
</script>
