<template>
	<div>
		<AppAdminHead title="Create Admin" />
		<BreadCrumbs :crumbs="crumbs" />

		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form id="create-form" @submit.prevent="store">
				<div class="form-control">
					<FormInputText
						class="pr-6 pb-8 w-full lg:w-1/2"
						label="Name"
						v-model="form.name"
						:error="form.errors.name"
					/>
					<FormInputText
						class="pr-6 pb-8 w-full lg:w-1/2"
						label="Email"
						v-model="form.email"
						:error="form.errors.email"
					/>
				</div>
				<div class="form-control">
					<FormInputText
						class="pr-6 pb-8 w-full lg:w-1/2"
						label="Father Name"
						v-model="form.father_name"
						:error="form.errors.father_name"
					/>
					<FormInputSelect
						class="pr-6 pb-8 w-full lg:w-1/2"
						label="Gender"
						v-model="form.gender"
						:error="form.errors.gender"
					>
						<option value="" selected></option>
						<option value="male">Male</option>
						<option value="female">Female</option>
					</FormInputSelect>
				</div>
				<div class="form-control">
					<FormInputText
						class="pr-6 pb-8 w-full lg:w-1/2"
						label="Phone Number"
						v-model="form.phone_number"
						:error="form.errors.phone_number"
					/>
					<FormInputText
						class="pr-6 pb-8 w-full lg:w-1/2"
						label="CNIC"
						v-model="form.cnic"
						:error="form.errors.cnic"
						placeholder="XXXXX-XXXXXXX-X"
						maxLength="13"
					/>
				</div>
				<div class="form-control">
					<FormInputText
						class="pr-6 pb-8 w-full lg:w-1/2"
						label="Password"
						v-model="form.password"
						:error="form.errors.password"
					/>
					<FormInputText
						class="pr-6 pb-8 w-full lg:w-1/2"
						label="Confirm Password"
						v-model="form.password_confirmation"
						:error="form.errors.password_confirmation"
					/>
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