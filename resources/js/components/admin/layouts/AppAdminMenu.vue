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
		isUrl(url) {
			let currentUrl = this.$page.url.substr(1);
			let arr = currentUrl.split("/");

			let isCurrent = false;
			arr.forEach(function(part) {
				if (part === url) {
					isCurrent = true;
					return;
				}
			});

			return isCurrent;
		}
	}
};
</script>