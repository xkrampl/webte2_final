import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import {ZiggyVue} from 'ziggy-js'

import '../css/app.css'
import base from './base.js'

import MainLayout from "./Pages/Layouts/MainLayout.vue";

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', {eager: true})

        const page = pages[`./Pages/${name}.vue`]
        page.default.layout = page.default.layout || MainLayout

        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mixin(base)
            .mount(el)
    },
    progress: {
        delay: 0,
        color: '#0284c7',
        includeCSS: true,
        showSpinner: true
    }
})
