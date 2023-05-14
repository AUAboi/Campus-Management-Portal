<template>
    <div class="flex flex-col text-indigo-300">
        <div class="nav-item">
            <Link
                :class="{ 'text-white': isUrl('dashboard') }"
                class="m-2"
                :href="route('admin.dashboard')"
                >Dashboard</Link
            >
        </div>
        <div class="nav-item">
            <Link
                :class="{ 'text-white': isUrl('profile') }"
                class="m-2"
                :href="route('admin.profile')"
                >Profile</Link
            >
        </div>
        <div class="nav-item">
            <Link
                :class="{ 'text-white': isUrl('faculties') }"
                class="m-2"
                :href="route('admin.faculties')"
                >Faculties</Link
            >
        </div>
        <div class="nav-item">
            <Link
                :class="{ 'text-white': isUrl('departments') }"
                class="m-2"
                :href="route('admin.departments')"
                >Departments
            </Link>
        </div>
        <div class="nav-item">
            <Link
                :class="{ 'text-white': isUrl('programs') }"
                class="m-2"
                :href="route('admin.programs')"
                >Programs</Link
            >
        </div>
        <div class="nav-item">
            <Link
                :class="{ 'text-white': isUrl('courses') }"
                class="m-2"
                :href="route('admin.courses')"
                >Courses</Link
            >
        </div>
        <div v-if="manage_applications" class="nav-item">
            <Link
                :class="{ 'text-white': isUrl('applications') }"
                class="m-2"
                :href="route('admin.applications')"
            >
                Applications</Link
            >
        </div>
        <!-- Sending to dropdown menu through portal -->
        <portal to="dropdownmenu">
            <TheDropdownMenu />
        </portal>
        <!-- Sending sloted main content through portal -->
        <portal to="maincontent">
            <slot />
        </portal>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

import TheDropdownMenu from "../../admin/layouts/TheDropdownMenu.vue";
import AppDropdown from "../../shared/ui/AppDropdown.vue";

import IconChevronDown from "~icons/mdi/chevron-down";

export default {
    components: {
        Link,
        TheDropdownMenu,
        AppDropdown,
        IconChevronDown
    },
    data() {
        return {
            manage_applications: false
        };
    },
    methods: {
        isUrl(...urls) {
            let currentUrl = this.$page.url.substr(1);
            currentUrl = currentUrl.replace("admin/", "");
            if (urls[0] === "") {
                return currentUrl === "";
            }
            return urls.filter(url => currentUrl.startsWith(url)).length;
        },
        async getPermission() {
            let res = await axios.get(
                this.route("api.admin.manage_applications")
            );
            this.manage_applications = res.data;
        }
    },
    computed: {
        user() {
            return this.$page.props.auth.user;
        },
        appName() {
            return this.$page.props.appName;
        }
    },
    mounted() {
        this.getPermission();
    }
};
</script>

<style scoped>
.nav-item {
    @apply my-2;
}
</style>
