<script setup>
import {usePage} from "@inertiajs/vue3";

const page = usePage()
</script>

<template>
    <div class="flex flex-col min-h-screen">
        <header class="bg-blue-600 text-white py-4">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">Voting system</h1>
                <nav>
                    <ul class="flex space-x-4">
                        <li>
                            <router-link to="/show" class="hover:bg-blue-700 py-2 px-4 rounded">Show</router-link>
                        </li>
                        <li>
                            <router-link to="/create" class="hover:bg-blue-700 py-2 px-4 rounded">Create</router-link>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="flex-grow container max-w-screen-2xl mx-auto px-4 py-8">
            <slot/>
        </main>

        <footer class="bg-gray-800 text-white py-4">
            <div class="container mx-auto px-4 text-center">
                <p>© 2024 Voting system. All rights reserved.</p>
            </div>
        </footer>
    </div>
</template>
