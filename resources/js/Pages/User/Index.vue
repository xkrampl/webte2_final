<template>
    <div class="p-6">
        <!-- Filter Form -->
        <div class="p-6 bg-gray-50 rounded-lg shadow">
            <!-- Filter Form -->
            <div class="flex flex-wrap gap-4 mb-8 items-center justify-center">
                <div class="w-full md:w-auto">
                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input v-model="filterForm.created_at" type="date" id="date"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/>
                </div>
                <div class="w-full md:w-auto">
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                    <select v-model="filterForm.subject" id="subject"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option disabled value="">Select a Subject</option>
                        <option v-for="subject in uniqueSubjects" :key="subject.id" :value="subject.id">{{
                                subject.name
                            }}
                        </option>
                    </select>
                </div>
                <button @click="filter"
                        class="btn btn-primary w-full md:w-auto px-6 py-2 mt-6 md:mt-6 text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm shadow-sm hover:shadow-md transition-colors">
                    Apply Filters
                </button>
                <button @click="clear"
                        class="btn btn-ghost w-full md:w-auto px-6 py-2 mt-6 md:mt-6 text-gray-700 bg-transparent hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm shadow-sm hover:shadow-md transition-colors">
                    Clear Filters
                </button>
            </div>
        </div>

        <!-- Questions List -->
        <div class="space-y-4">
            <div v-for="question in questions" :key="question.id"
                 class="border-2 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-lg font-bold mb-1">{{ question.subject.name }}</h2>
                        <p class="text-gray-700">{{ question.description }}</p>
                    </div>
                    <span :class="tagColor(question.type)"
                          class="text-sm font-semibold px-3 py-1 rounded-full text-white">{{ question.type }}</span>
                </div>
                <div class="mt-2">
          <span :class="{'text-green-500': question.is_active, 'text-red-500': !question.is_active}"
                class="font-medium">
            {{ question.is_active ? 'Active' : 'Inactive' }}
          </span>
                </div>
                <div class="mt-4">
                    <h3 class="font-semibold">Answers:</h3>
                    <ul>
                        <li v-for="answer in question.answers" :key="answer.id" class="mt-2 flex items-center">
                            <p class="flex-1">{{ answer.text }}</p>
                            <span :class="answer.is_correct ? 'text-green-500' : 'text-red-500'" class="font-medium">
                {{ answer.is_correct ? '✓' : '✗' }}
              </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {computed} from "vue";
import {useForm} from "@inertiajs/vue3";
import {route} from "ziggy-js";

const props = defineProps({
    questions: Object,
    filters: Object
})

const questions = computed(() => props.questions)
const filterForm = useForm({
    created_at: props.filters.created_at ?? null,
    subject: props.filters.subject ?? null,
})

const filter = () => {
    filterForm.get(route('user.question.index'), {
        preserveState: true,
        preserveScroll: true
    })
}

const clear = () => {
    filterForm.created_at = null
    filterForm.subject = null
    filter()
}

const uniqueSubjects = computed(() => {
    const subjects = questions.value.map(q => q.subject);
    return Array.from(new Set(subjects.map(s => JSON.stringify(s))), JSON.parse);
});

const tagColor = (type) => {
    if (type === 'answers') return 'bg-blue-500';
    if (type === 'archived') return 'bg-red-500';
    return 'bg-green-500';
}
</script>
