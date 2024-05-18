<template>
    <!-- menu source: https://tailwindui.com/components/application-ui/elements/dropdowns-->
    <div class="flex flex-col min-h-screen">
        <header class="bg-blue-300 text-white py-4">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">{{ __('Voting System') }}</h1>

                <div class="flex space-x-4 items-center">
                    <language-selector class="order-last ml-4"/>

                    <nav>
                        <ul class="flex space-x-4">
                            <li class="relative">
                                <Menu as="div" class="relative inline-block text-left">
                                    <MenuButton
                                        class="inline-flex justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                                        {{ __('Menu') }}
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
                                                        {{ __('Home') }}
                                                    </Link>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }"
                                                          v-if="page.props.user && !page.props.user.is_admin">
                                                    <Link :href="route('user.dashboard')"
                                                          :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                        {{ __('Dashboard') }}
                                                    </Link>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }"
                                                          v-if="page.props.user && page.props.user.is_admin">
                                                    <Link :href="route('admin.dashboard')"
                                                          :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                        {{ __('Dashboard') }}
                                                    </Link>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }"
                                                          v-if="page.props.user && page.props.user.is_admin">
                                                    <Link :href="route('admin.user.index')"
                                                          :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                        {{ __('View Users') }}
                                                    </Link>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }"
                                                          v-if="page.props.user && page.props.user.is_admin">
                                                    <Link :href="route('admin.user.create')"
                                                          :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                        {{ __('Create New User') }}
                                                    </Link>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }"
                                                          v-if="page.props.user && !page.props.user.is_admin">
                                                    <Link :href="route('question.create')"
                                                          :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                        {{ __('Create Question') }}
                                                    </Link>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }"
                                                          v-if="page.props.user && page.props.user.is_admin">
                                                    <Link :href="route('admin.question.create')"
                                                          :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                        {{ __('Create Question') }}
                                                    </Link>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }" v-if="!page.props.user">
                                                    <Link :href="route('login')"
                                                          :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                        {{ __('Login') }}
                                                    </Link>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }" v-if="page.props.user">
                                                    <Link method="get" :href="route('change-password.create')"
                                                          :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                        {{ __('Change Password') }}
                                                    </Link>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }" v-if="page.props.user">
                                                    <Link :href="route('login.destroy')" method="delete" as="button"
                                                          :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                        {{ __('Logout') }}
                                                    </Link>
                                                </MenuItem>
                                            </div>
                                        </MenuItems>
                                    </transition>
                                </Menu>
                            </li>
                        </ul>
                    </nav>

                    <button @click="isModalOpen = true"
                            class="py-2 px-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        {{ __('Manual') }}
                    </button>
                    <!-- Modal Section -->
                    <!-- Modal Section -->
                    <transition name="fade">
                        <div v-if="isModalOpen"
                             class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                <div class="mt-3">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 text-center">
                                        {{ __('User Manual') }}</h3>
                                    <div class="mt-2 px-7 py-3 text-sm text-gray-500 pdf-content">
                                        <p>
                                            Here is a <b>manual</b> for the page. Firstly we will start with roles and
                                            their
                                            permissions.
                                        </p>
                                        <ul class="list-disc list-inside">
                                            <li>
                                                <b>Unlogged user</b>: join voting for specific question via code/QR,
                                                view voting results

                                            </li>
                                            <li>
                                                <b>Logged user</b>: same as unlogged user, define your own voting
                                                questions,
                                                change password, activate/deactivate your questions, edit/delete/copy
                                                your existing questions,
                                                define questions subject, filter questions based on subject and date of
                                                creation, view also archived questions, export questions and answers to
                                                JSON
                                            </li>
                                            <li>
                                                <b>Admin</b>: same as logged user, ability to view all questions and act
                                                on behalf of all other users, CRUD operations regarding all users
                                            </li>
                                        </ul>
                                        <p>
                                            <b>The homepage</b> consists of form where you can insert 5-letter code/scan
                                            QR code to join voting, but also edit/delete/duplicate/deactivate question,
                                            close voting, etc..
                                            In the top right corner, you will see <B>menu, manual and language
                                            selector</B>. From the menu you have multiple options like displaying
                                            dashboard, creating questions, managing account, etc.. Menu items depend on
                                            the role of specific user.
                                        </p>
                                    </div>

                                    <div class="items-center px-4 py-3">
                                        <button @click="exportToPDF"
                                                class="mb-2 px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                            {{ __('Export to PDF') }}
                                        </button>
                                        <button @click="isModalOpen = false"
                                                class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                            {{ __('Close') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition>


                </div>
            </div>
        </header>

        <div v-if="flashSuccess" class="mb-4 border rounded-md shadow-sm bg-gradient-to-r from-purple-600 to-blue-400 text-white p-2">
            {{ flashSuccess }}
        </div>

        <div v-if="flashError" class="mb-4 border rounded-md shadow-sm bg-gradient-to-r from-red-600 to-rose-400 text-white p-2">
            {{ flashError }}
        </div>

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
import {computed, ref} from 'vue';
import {jsPDF} from "jspdf";
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {ChevronDownIcon} from '@heroicons/vue/20/solid'
import LanguageSelector from "../Components/LanguageSelector.vue";
import {Link, usePage} from "@inertiajs/vue3";
import {route} from "ziggy-js";

const page = usePage();
const isModalOpen = ref(false);

function exportToPDF() {
    const content = document.querySelector('.pdf-content').innerText;
    const doc = new jsPDF({
        orientation: 'portrait',
        unit: 'pt',
        format: 'a4'
    });

    const lines = doc.splitTextToSize(content, 500); // Split long text into lines that fit the page width
    doc.text(lines, 40, 40); // Start the text 40 points from the top and 40 from the left margin
    doc.save('user-manual.pdf');
}

const flashSuccess = computed(() => page.props.flash.success)
const flashError = computed(() => page.props.flash.error)

console.log(page.props.flash)
</script>

<style scoped>
/* Additional styles if needed */
</style>
