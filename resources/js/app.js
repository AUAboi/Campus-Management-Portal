import './bootstrap';
import '../css/app.css';

import VueTheMask from "vue-the-mask";

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import Layout from "@/components/shared/layouts/Layout.vue"
import TheAdminLayout from "@/components/admin/layouts/TheAdminLayout.vue"
import AppStudentMenu from "@/components/student/layouts/AppStudentMenu.vue"
import TheApplicantMenu from "@/components/applicant/layouts/TheApplicantMenu.vue"


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async name => {
        const page = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'))
        if (page.default.layout === undefined) {
            if (name.startsWith("Admin")) {
                page.default.layout = TheAdminLayout;
            } else if (name.startsWith("Student")) {
                page.default.layout = [Layout, AppStudentMenu];
            } else if (name.startsWith("Applicant")) {
                page.default.layout = [Layout, TheApplicantMenu];
            }
        }
        return page;
    },
    progress: {
        showSpinner: true,
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(VueTheMask)
            .mount(el);
    },
});

