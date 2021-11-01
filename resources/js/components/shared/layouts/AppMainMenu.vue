<template>
	<nav>
		<div class="flex flex-col text-indigo-300">
			<Link
				:class="{ 'text-white': $page.url === '/student/dashboard' }"
				class="m-2"
				href="./dashboard"
				>Dashboard</Link
			>
			<Link
				:class="{ 'text-white': $page.url === '/student/profile' }"
				class="m-2"
				href="./profile"
				>Profile</Link
			>
			<Link
				:class="{ 'text-white': $page.url === '/student/course-details' }"
				class="m-2"
				href="./course-details"
				>Course Details</Link
			>
		</div>
	</nav>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";

export default {
	components: {
		Link
	}
};
</script>