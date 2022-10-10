/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;

Vue.prototype.$route = route;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context("./", true, /\.vue$/i);
// files.keys().map(key =>
//     Vue.component(
//         key
//             .split("/")
//             .pop()
//             .split(".")[0],
//         files(key).default
//     )
// );

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import { createInertiaApp } from "@inertiajs/inertia-vue";

//Layouts
//We are loading these lazily so only required routes load these
const Layout = () => ({
    component: import("./components/shared/layouts/Layout")
});
const TheAdminMenu = () => ({
    component: import("./components/admin/layouts/TheAdminMenu")
});
const TheApplicantMenu = () => ({
    component: import("./components/applicant/layouts/TheApplicantMenu")
});
const AppStudentMenu = () => ({
    component: import("./components/student/layouts/AppStudentMenu")
});

import "sweetalert2/dist/sweetalert2.min.css";

import { InertiaProgress } from "@inertiajs/progress";
import VueSweetalert2 from "vue-sweetalert2";
import VueTheMask from "vue-the-mask";
import PortalVue from "portal-vue";

Vue.use(VueSweetalert2);
Vue.use(VueTheMask);
Vue.use(PortalVue);

InertiaProgress.init();

createInertiaApp({
    resolve: async name => {
        const page = await (await import(`./Pages/${name}`)).default;
        if (page.layout === undefined) {
            if (name.startsWith("Admin")) {
                page.layout = [Layout, TheAdminMenu];
            } else if (name.startsWith("Student")) {
                page.layout = [Layout, AppStudentMenu];
            } else if (name.startsWith("Applicant")) {
                page.layout = [Layout, TheApplicantMenu];
            }
        }
        return page;
    },
    setup({ el, App, props }) {
        new Vue({
            render: h => h(App, props)
        }).$mount(el);
    }
});
