<template>
	<main>
		<AppAdminHead :title="`User ${user.name}`" />
		<h1 class="mb-8 font-bold text-3xl">{{ user.name }}</h1>

		<component :user="user" :is="`app-${role}-profile-card`"></component>

		<div v-if="permissions.edit" class="py-4 my-4  max-w-3xl">
			<Link :href="$route('admin.users.edit', user.id)" class="btn-main">
				Edit
			</Link>
		</div>
	</main>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
export default {
	components: {
		Link
	},
	props: {
		user: {
			required: true,
			type: Object
		},
		permissions: Object
	},
	computed: {
		role() {
			return this.user.role;
		}
	}
};
</script>