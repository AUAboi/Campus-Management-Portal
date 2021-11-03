<template>
	<div class="flex flex-col text-indigo-300">
		<div class="nav-item">
			<Link
				:class="{ 'text-white': $page.url.endsWith('dashboard') }"
				class="m-2"
				href="./dashboard"
				>Dashboard</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': $page.url.endsWith('profile') }"
				class="m-2"
				href="./profile"
				>Profile</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': $page.url.endsWith('course-details') }"
				class="m-2"
				href="./course-details"
				>Course Details</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': $page.url.endsWith('faculties') }"
				class="m-2"
				href="./faculties"
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
	}
};
</script>