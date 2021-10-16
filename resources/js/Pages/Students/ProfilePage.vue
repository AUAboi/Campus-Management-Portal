<template>
	<main>
		<Head title="Student - Profile" />
		<H1>Welcome, user!</H1>
		<p>Hello welcome to your first Inertia profile!</p>
		<p>User: {{ user }}</p>
		<AppUserAvatar :avatar="user.avatar" />
	</main>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue";
export default {
	components: {
		Head
	},
	props: {
		user: {
			required: true,
			type: Object
		}
	}
};
</script>