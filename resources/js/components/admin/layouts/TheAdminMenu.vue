<template>
	<div class="flex flex-col text-indigo-300">
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('dashboard') }"
				class="m-2"
				:href="$route('admin.dashboard')"
				>Dashboard</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('profile') }"
				class="m-2"
				:href="$route('admin.profile')"
				>Profile</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('faculties') }"
				class="m-2"
				:href="$route('admin.faculties')"
				>Faculties</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('departments') }"
				class="m-2"
				:href="$route('admin.departments')"
				>Departments</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('programs') }"
				class="m-2"
				:href="$route('admin.programs')"
				>Programs</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('courses') }"
				class="m-2"
				:href="$route('admin.courses')"
				>Courses</Link
			>
		</div>

		<!-- Sending sloted main content through portal -->
		<portal to="maincontent">
			<slot />
		</portal>
	</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";

export default {
	components: {
		Link
	},
	methods: {
		isUrl(...urls) {
			let currentUrl = this.$page.url.substr(1);
			currentUrl = currentUrl.replace("admin/", "");
			if (urls[0] === "") {
				return currentUrl === "";
			}
			return urls.filter(url => currentUrl.startsWith(url)).length;
		}
	}
};
</script>

<style scoped>
.nav-item {
	@apply my-2;
}
</style>