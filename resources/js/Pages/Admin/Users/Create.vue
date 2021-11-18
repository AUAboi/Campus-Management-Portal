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
			<form class="m-0" @submit.prevent="store">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">User Name: </label>
						<input type="text" v-model="form.name" class="form_input" />
						<div class="text-red-600" v-if="form.errors.name">
							{{ form.errors.name }}
						</div>
					</div>
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Email: </label>
						<input type="text" v-model="form.email" class="form_input" />
						<div class="text-red-600" v-if="form.errors.email">
							{{ form.errors.email }}
						</div>
					</div>
				</div>
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Password: </label>
						<input type="text" v-model="form.password" class="form_input" />
						<div class="text-red-600" v-if="form.errors.password">
							{{ form.errors.password }}
						</div>
					</div>
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Role: </label>
						<select v-model="form.role" class="form_input">
							<option value="student">student</option>
							<option value="teacher">teacher</option>
							<option value="admin">admin</option>
						</select>
						<div class="text-red-600" v-if="form.errors.role">
							{{ form.errors.role }}
						</div>
					</div>
				</div>

				<div
					class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center"
				>
					<button
						:disabled="form.processing"
						type="submit"
						class="bg-indigo-500 text-white inline px-4 py-2 cursor-pointer rounded-md"
					>
						Create User
					</button>
				</div>
			</form>
		</div>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl mt-4">
			<div v-if="form.role === 'student'">
				<h1>Student</h1>
			</div>
			<div v-else-if="form.role === 'admin'">
				<h1>Admin</h1>
			</div>
			<div v-else-if="form.role === 'teacher'">
				<h1>Teacher</h1>
			</div>
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
				email: "",
				password: "",
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
		form: {
			deep: true,
			handler: function() {
				if (this.form.password.length === 0) {
					this.form.errors.password = "";
					return;
				} else if (this.form.password.length < 8) {
					this.form.errors.password = "Password must be at least 8 characters";
					return;
				} else if (this.form.password.search(/[0-9]/) < 0) {
					this.form.errors.password =
						"Password must contain at least one number";
					return;
				} else if (this.form.password.search(/[a-z]/) < 0) {
					this.form.errors.password =
						"Password must contain at least one lowercase letter";
					return;
				} else if (this.form.password.search(/[A-Z]/) < 0) {
					this.form.errors.password =
						"Password must contain at least one uppercase letter";
					return;
				}
				this.form.errors.password = "";
			}
		}
	}
};
</script>
