<template>
	<div>
		<AppAdminHead title="Create User" />

		<h1 class="mb-8 font-bold text-3xl">
			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.users')"
				>Users</Link
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
			formStep: 1,
			form: this.$inertia.form({
				name: "",
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
			this.form.post(this.$route("admin.users.create"));
		}
	},
	watch: {
		"form.role": function() {
			//Reset role form
		}
	}

	// watch: {
	// 	form: {
	// 		deep: true,
	// 		handler: function() {
	// 			if (!this.form.password.length) {
	// 				this.form.errors.password = "";
	// 				return;
	// 			} else if (this.form.password.length < 8) {
	// 				this.form.errors.password = "Password must be at least 8 characters";
	// 				return;
	// 			} else if (this.form.password.search(/[0-9]/) < 0) {
	// 				this.form.errors.password =
	// 					"Password must contain at least one number";
	// 				return;
	// 			} else if (this.form.password.search(/[a-z]/) < 0) {
	// 				this.form.errors.password =
	// 					"Password must contain at least one lowercase letter";
	// 				return;
	// 			} else if (this.form.password.search(/[A-Z]/) < 0) {
	// 				this.form.errors.password =
	// 					"Password must contain at least one uppercase letter";
	// 				return;
	// 			}
	// 			this.form.errors.password = "";
	// 		}
	// 	}
	// }
};
</script>
