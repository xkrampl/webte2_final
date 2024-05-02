<template>
    <form @submit.prevent="login" class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md mt-12">
        <div class="w-full max-w-sm mx-auto">
            <div>
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">E-mail</label>
                <input id="email" v-model="form.email" type="text"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                <div v-if="form.errors.email" class="text-red-500 text-xs italic">{{ form.errors.email }}</div>
            </div>
            <div class="mt-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input id="password" v-model="form.password" type="password"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"/>
                <div v-if="form.errors.password" class="text-red-500 text-xs italic">{{ form.errors.password }}</div>
            </div>
            <div class="mt-4">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                    type="submit">Login
                </button>

                <div class="mt-2 text-center">
                    <Link :href="route('register.create')"
                          class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Need
                        an account? Click here.
                    </Link>

                    <Link :href="route('forgot-password.create')"
                          class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Forgot
                        your password? Click here.
                    </Link>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import {route} from "ziggy-js";

const form = useForm({
    email: null,
    password: null,
})
const login = () => form.post(route('login.store'))
</script>
