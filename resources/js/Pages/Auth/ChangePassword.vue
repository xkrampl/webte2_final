<template>
    <form @submit.prevent="changePassword" class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md mt-12">
        <div class="w-full max-w-sm mx-auto">
            <div class="mt-4">
                <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Current
                    Password</label>
                <input id="current_password" v-model="form.current_password" type="password"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"/>
                <div v-if="form.errors.current_password" class="text-red-500 text-xs italic">
                    {{ form.errors.current_password }}
                </div>
            </div>

            <div class="mt-4">
                <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                <input id="new_password" v-model="form.new_password" type="password"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"/>
                <div v-if="form.errors.new_password" class="text-red-500 text-xs italic">
                    {{ form.errors.new_password }}
                </div>
            </div>

            <!-- New password confirmation input -->
            <div class="mt-4">
                <label for="new_password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm New
                    Password</label>
                <input id="new_password_confirmation" v-model="form.new_password_confirmation" type="password"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                <div v-if="form.errors.new_password_confirmation" class="text-red-500 text-xs italic">
                    {{ form.errors.new_password_confirmation }}
                </div>
            </div>

            <div class="mt-4">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                    type="submit">
                    Change Password
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3'
import {route} from "ziggy-js";

const form = useForm({
    current_password: null,
    new_password: null,
    new_password_confirmation: null  // Ensure this is added to the useForm initialization
})
const changePassword = () => form.post(route('change-password.store'))
</script>
