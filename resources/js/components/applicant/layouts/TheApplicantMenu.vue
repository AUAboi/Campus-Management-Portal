<template>
	<div class="flex flex-col text-indigo-300">
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('dashboard') }"
				class="m-2"
				:href="$route('applicant.dashboard')"
				>Dashboard</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('applications') }"
				class="m-2"
				:href="$route('applicant.applications')"
				>Applications</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('academic_details') }"
				class="m-2"
				:href="$route('applicant.applications')"
				>Academic Details</Link
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
import { Link } from "@inertiajs/inertia-vue";
import TheDropdownMenu from "../../applicant/layouts/TheDropdownMenu.vue";
import AppDropdown from "../../shared/ui/AppDropdown.vue";

import { ChevronDownIcon } from "@vue-hero-icons/outline";

export default {
	components: {
		Link,
		TheDropdownMenu,
		AppDropdown,
		ChevronDownIcon
	},
	methods: {
		isUrl(...urls) {
			let currentUrl = this.$page.url.substr(1);
			currentUrl = currentUrl.replace("applicant/", "");
			if (urls[0] === "") {
				return currentUrl === "";
			}
			return urls.filter(url => currentUrl.startsWith(url)).length;
		}
	},
	computed: {
		user() {
			return this.$page.props.auth.user;
		},
		appName() {
			return this.$page.props.appName;
		}
	}
};
</script>

<style scoped>
.nav-item {
	@apply my-2;
}
</style>