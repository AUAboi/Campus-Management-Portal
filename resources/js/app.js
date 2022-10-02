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

const files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>
    Vue.component(
        key
            .split("/")
            .pop()
            .split(".")[0],
        files(key).default
    )
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import { createInertiaApp } from "@inertiajs/inertia-vue";

//Layouts
import Layout from "./components/shared/layouts/Layout";
import TheAdminMenu from "./components/admin/layouts/TheAdminMenu";
import AppStudentMenu from "./components/student/layouts/AppStudentMenu";
import AppAdminHead from "./components/admin/layouts/AppAdminHead";

import PortalVue from "portal-vue";

import { InertiaProgress } from "@inertiajs/progress";

Vue.use(PortalVue);

//Global components
Vue.component(AppAdminHead);

InertiaProgress.init();

createInertiaApp({
    resolve: name => {
        const page = require(`./Pages/${name}`).default;
        if (page.layout === undefined) {
            if (name.startsWith("Admin")) {
                page.layout = [Layout, TheAdminMenu];
            } else if (name.startsWith("Student")) {
                page.layout = [Layout, AppStudentMenu];
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
