<template>
	<main>
		<AppAdminHead title="Profile - Student" />

		<AppStudentProfileCard :user="user" />
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