<template>
	<main>
		{{ user }}
		<TheAdminHead :title="`User ${user.name}`" />
		<h1 class="mb-8 font-bold text-3xl">{{ user.name }}</h1>

		<component :user="user" :is="`${role}-profile-card`"></component>

		<div v-if="permissions.edit" class="py-4 my-4  max-w-3xl">
			<Link
				:href="$route(`admin.users.${role}.edit`, user.id)"
				class="btn-main"
			>
				Edit
			</Link>
		</div>
	</main>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import TheAdminHead from "../../../components/admin/meta/TheAdminHead.vue";
export default {
	components: {
		Link,
		TheAdminHead
	},
	props: {
		user: {
			required: true,
			type: Object
		},
		permissions: {
			Object,
			required: false
		}
	},
	computed: {
		role() {
			return this.user.roles[0].name;
		}
	}
};
</script>