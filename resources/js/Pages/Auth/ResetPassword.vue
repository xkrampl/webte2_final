<template>
    <form @submit.prevent="resetPassword">
        <div class="w-1/2 mx-auto">
            <div class="mt-4">
                <label for="email" class="label">E-mail</label>
                <input id="email" v-model="form.email" type="text" class="input"/>
                <div v-if="form.errors.email" class="input-error">{{ form.errors.email }}</div>
            </div>
            <div class="mt-4">
                <label for="password" class="label">Password</label>
                <input id="password" v-model="form.password" type="password" class="input"/>
            </div>
            <div class="mt-4">
                <label for="password_confirmation" class="label">Confirm Password</label>
                <input id="password_confirmation" v-model="form.password_confirmation" type="password" class="input"/>
                <div v-if="form.errors.password" class="input-error">{{ form.errors.password }}</div>
            </div>
            <div class="mt-4">
                <button class="btn-primary w-full" type="submit">Reset password</button>

                <div class="mt-2 text-center">
                    <Link :href="route('homepage')" class="text-sm text-gray-500">Go back home.</Link>
                </div>
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
