<template>
	<div>
		<AppAdminHead title="Create Admin" />
		<BreadCrumbs :crumbs="crumbs" />

		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form id="create-form" @submit.prevent="store">
				<div class="form-row">
					<FormInputText label="Name" v-model="form.name" :error="form.errors.name" />
					<FormInputText label="Email" v-model="form.email" :error="form.errors.email" />
				</div>
				<div class="form-row">
					<FormInputText label="Father Name" v-model="form.father_name" :error="form.errors.father_name" />
					<FormInputSelect label="Gender" v-model="form.gender" :error="form.errors.gender">
						<option value="" selected></option>
						<option value="male">Male</option>
						<option value="female">Female</option>
					</FormInputSelect>
				</div>
				<div class="form-row">
					<FormInputText label="Phone Number" v-model="form.phone_number" :error="form.errors.phone_number" />
					<FormInputText label="CNIC" v-model="form.cnic" :error="form.errors.cnic" placeholder="XXXXX-XXXXXXX-X"
						maxLength="13" />
				</div>
				<div class="form-row">
					<FormInputText label="Password" v-model="form.password" :error="form.errors.password" />
					<FormInputText label="Confirm Password" v-model="form.password_confirmation"
						:error="form.errors.password_confirmation" />
				</div>
				<div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
					<button :disabled="form.processing" type="submit" class="btn-main" form="create-form">
						Create User
					</button>
				</div>
			</form>
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
			}),
			crumbs: [
				{
					text: "Users",
					route: this.$route("admin.users")
				},
				{
					text: "Admin",
					route: this.$route("admin.users", { role: "admin" })
				},
				{
					text: "Create"
				}
			]
		};
	},
	methods: {
		store() {
			this.form.post(this.$route("admin.users.admin.store"));
		}
	}
};
</script>