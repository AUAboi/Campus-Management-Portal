import './bootstrap';
import '../css/app.css';

import VueTheMask from "vue-the-mask";

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

//Layouts
//We are loading these lazily so only required routes load these
// const Layout = () => ({
//     component: import("./components/shared/layouts/Layout")
// });
// const TheAdminMenu = () => ({
//     component: import("./components/admin/layouts/TheAdminMenu")
// });
// const TheApplicantMenu = () => ({
//     component: import("./components/applicant/layouts/TheApplicantMenu")
// });
// const AppStudentMenu = () => ({
//     component: import("./components/student/layouts/AppStudentMenu")
// });

import Layout from "@/components/shared/layouts/Layout.vue"
import TheAdminMenu from "@/components/admin/layouts/TheAdminMenu.vue"
import AppStudentMenu from "@/components/student/layouts/AppStudentMenu.vue"
import TheApplicantMenu from "@/components/applicant/layouts/TheApplicantMenu.vue"


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async name => {
        const page = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'))
        if (page.default.layout === undefined) {
            if (name.startsWith("Admin")) {
                page.default.layout = [Layout, TheAdminMenu];
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

