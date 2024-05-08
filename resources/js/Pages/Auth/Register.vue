<template>
    <form @submit.prevent="register" class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md mt-12">
        <div class="w-full max-w-sm mx-auto">

            <div>
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Name') }}</label>
                <input id="name" v-model="form.name" type="text"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                <div v-if="form.errors.name" class="text-red-500 text-xs italic">{{ form.errors.name }}</div>
            </div>

            <div>
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">{{ __('E-mail') }}</label>
                <input id="email" v-model="form.email" type="text"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                <div v-if="form.errors.email" class="text-red-500 text-xs italic">{{ form.errors.email }}</div>
            </div>
            <div class="mt-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Password') }}</label>
                <input id="password" v-model="form.password" type="password"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"/>
                <div v-if="form.errors.password" class="text-red-500 text-xs italic">{{ form.errors.password }}</div>
            </div>

            <div class="mt-4">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">{{
                        __('Password')
                    }}</label>
                <input id="password_confirmation" v-model="form.password_confirmation" type="password_confirmation"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"/>
                <div v-if="form.errors.password_confirmation" class="text-red-500 text-xs italic">
                    {{ form.errors.password_confirmation }}
                </div>
            </div>
            <div class="mt-4">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                    type="submit">{{ __('Register') }}
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3'
import {route} from "ziggy-js";

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null
})
const register = () => form.post(route('register.store'))
</script>
