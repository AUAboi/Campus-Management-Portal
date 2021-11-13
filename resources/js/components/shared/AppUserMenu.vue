<template>
	<div>
		<Link
			class="block px-6 py-2 hover:bg-indigo-500 hover:text-white"
			href="./profile"
			>My Profile</Link
		>
		<Link class="block px-6 py-2 hover:bg-indigo-500 hover:text-white"
		:href="$route('admin.users')"
			>Manage Users</Link
		>

		<!-- logout temperary -->
		<Link
			class="block px-6 py-2 hover:bg-indigo-500 hover:text-white w-full text-left"
			href="/logout"
			method="post"
			as="button"
			>Logout</Link
		>
	</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";

export default {
	components: {
		Link
	},
	methods: {
		async logoutUser() {
			let res = await axios.post("/logout");
		}
	}
};
</script>