<template>
	<main>
		<AppAdminHead title="Profile" />

		<h1 class="mb-8 font-bold text-3xl">{{ user.name }}</h1>

		<AppAdminProfileCard :user="user" />
	</main>
</template>

<script>
export default {
	props: {
		user: {
			required: true,
			type: Object
		}
	}
};
</script>