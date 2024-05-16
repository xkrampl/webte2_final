<script setup>
import {computed} from "vue";
import {route} from "ziggy-js";
import {useForm} from '@inertiajs/vue3'

const props = defineProps({
    user: Object
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    is_admin: props.user.is_admin !== undefined ? props.user.is_admin : 0,
});

const user = computed(() => props.user);

const save = () => {
    form.put(route('admin.user.update', user.value));
}
</script>

<template>
    <div class="max-w-4xl mx-auto py-10">
        <form @submit.prevent="save" class="space-y-6 bg-white p-6 rounded shadow">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                <input type="text" id="name" v-model="form.name"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                <input type="email" id="email" v-model="form.email"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       required>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                <input type="password" id="password" v-model="form.password"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="is_admin" class="block text-sm font-medium text-gray-700">{{ __('Admin') }}</label>
                <select id="is_admin" v-model="form.is_admin"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="0">{{ __('No') }}</option>
                    <option value="1">{{ __('Yes') }}</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Save Changes') }}
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>
/* Additional styles can be added here if necessary */
</style>
