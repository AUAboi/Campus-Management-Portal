<template>
	<div>
		<AppAdminHead title="Create Admin" />

		<h1 class="mb-8 font-bold text-3xl">
			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.users')"
				>Users/</Link
			>
			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.users', { role: 'admin' })"
				>Admin</Link
			>
			<span class="text-indigo-400 font-medium">/</span> Create
		</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<AppUserCreateForm :form="form" />
		</div>
		<div class="mt-2 pr-8 py-4 bg-gray-50 border-t border-gray-100 ">
			<button
				:disabled="form.processing"
				type="submit"
				class="btn-main"
				form="create-form"
			>
				Create User
			</button>
		</div>
	</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";

export default {
	components: {
		Link
	},
	data() {
		return {
			form: this.$inertia.form({
				name: "",
				father_name: "",
				gender: "",
				email: "",
				password: "",
				cnic: "",
				phone: "",
				role: ""
			})
		};
	},
	methods: {
		store() {
			this.form.post(this.$route("admin.users.admin.store"));
		}
	}
};
</script>