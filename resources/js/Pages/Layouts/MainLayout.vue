<template>
    <!-- menu source: https://tailwindui.com/components/application-ui/elements/dropdowns-->
    <div class="flex flex-col min-h-screen">
        <header class="bg-blue-300 text-white py-4">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">Voting system</h1>

                <language-selector />

                <nav>
                    <ul class="flex space-x-4">
                        <li class="relative">
                            <Menu as="div" class="relative inline-block text-left">
                                <MenuButton
                                    class="inline-flex justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                                    Menu
                                    <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5" aria-hidden="true"/>
                                </MenuButton>
                                <transition enter-active-class="transition ease-out duration-100"
                                            enter-from-class="transform opacity-0 scale-95"
                                            enter-to-class="transform opacity-100 scale-100"
                                            leave-active-class="transition ease-in duration-75"
                                            leave-from-class="transform opacity-100 scale-100"
                                            leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems
                                        class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <div class="py-1">
                                            <MenuItem v-slot="{ active }">
                                                <Link href="/"
                                                      :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                    Home
                                                </Link>
                                            </MenuItem>
                                            <MenuItem v-slot="{ active }" v-if=page.props.user>
                                                <Link :href="route('question.create')"
                                                      :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                    Create Question
                                                </Link>
                                            </MenuItem>
                                            <MenuItem v-slot="{ active }" v-if="!page.props.user">
                                                <Link :href="route('login.create')"
                                                      :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                    Login
                                                </Link>
                                            </MenuItem>
                                            <MenuItem v-slot="{ active }" v-if="page.props.user">
                                                <Link method="delete" as="button" :href="route('login.destroy')"
                                                      :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                    Logout
                                                </Link>
                                            </MenuItem>
                                        </div>
                                    </MenuItems>
                                </transition>
                            </Menu>
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


<script setup>
import {Link, usePage} from "@inertiajs/vue3";
import {route} from "ziggy-js";
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {ChevronDownIcon} from '@heroicons/vue/20/solid'
import LanguageSelector from "../Components/LanguageSelector.vue";

const page = usePage();
</script>

<style scoped>
/* Additional styles if needed */
</style>
