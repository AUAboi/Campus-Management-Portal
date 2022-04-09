<template>
	<div>
		<AppAdminHead title="Create Admin" />

		<h1 class="mb-8 font-bold text-3xl">
			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.users')"
				>Users
			</Link>
			<span class="text-indigo-400 font-medium">/</span>
			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.users', { role: 'admin' })"
				>Admin</Link
			>
			<span class="text-indigo-400 font-medium">/</span> Create
		</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form id="create-form" @submit.prevent="store">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Name: </label>
						<input type="text" v-model="form.name" class="form-input" />
						<div class="text-red-600" v-if="form.errors.name">
							{{ form.errors.name }}
						</div>
					</div>
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Email: </label>
						<input type="text" v-model="form.email" class="form-input" />
						<div class="text-red-600" v-if="form.errors.email">
							{{ form.errors.email }}
						</div>
					</div>
				</div>
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Father Name: </label>
						<input type="text" v-model="form.father_name" class="form-input" />
						<div class="text-red-600" v-if="form.errors.father_name">
							{{ form.errors.father_name }}
						</div>
					</div>
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Gender: </label>
						<select v-model="form.gender" class="form-input">
							<option value="" selected></option>
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>
						<div class="text-red-600" v-if="form.errors.gender">
							{{ form.errors.gender }}
						</div>
					</div>
				</div>
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Phone Number: </label>
						<input type="text" v-model="form.phone" class="form-input" />
						<div class="text-red-600" v-if="form.errors.phone">
							{{ form.errors.phone }}
						</div>
					</div>
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">CNIC: </label>
						<input
							type="text"
							maxlength="13"
							v-model="form.cnic"
							placeholder="XXXXX-XXXXXXX-X"
							class="form-input"
						/>
						<div class="text-red-600" v-if="form.errors.cnic">
							{{ form.errors.cnic }}
						</div>
					</div>
				</div>
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Password: </label>
						<input type="text" v-model="form.password" class="form-input" />
						<div class="text-red-600" v-if="form.errors.password">
							{{ form.errors.password }}
						</div>
					</div>
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Confirm Password: </label>
						<input
							type="text"
							v-model="form.password_confirmation"
							class="form-input"
						/>
						<div class="text-red-600" v-if="form.errors.password_confirmation">
							{{ form.errors.password_confirmation }}
						</div>
					</div>
				</div>
			</form>
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
				password_confirmation: "",
				cnic: "",
				phone: ""
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