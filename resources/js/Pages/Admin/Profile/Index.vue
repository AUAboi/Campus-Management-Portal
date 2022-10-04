<template>
	<main>
		<TheAdminHead title="Profile" />
		<h1 class="mb-8 font-bold text-3xl">{{ user.name }}</h1>
		<AdminProfileCard :user="user" />
	</main>
</template>

<script>
import AdminProfileCard from "../../../components/admin/AdminProfileCard.vue";
import TheAdminHead from "../../../components/admin/meta/TheAdminHead.vue";
export default {
	props: {
		user: {
			required: true,
			type: Object
		}
	},
	components: { AdminProfileCard, TheAdminHead }
};
</script>