<template>
	<div>
		<AppAdminHead title="Create Student" />
		<BreadCrumbs :crumbs="crumbs" />
		<div class="overflow-hidden max-w-3xl bg-white rounded-md shadow">
			{{ form }}
			<form class="m-0" id="create-form" @submit.prevent="store">
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
					<FormInputText label="Phone Number" v-model="form.phone" :error="form.errors.phone" />
					<FormInputText label="CNIC" v-model="form.cnic" :error="form.errors.cnic" placeholder="XXXXX-XXXXXXX-X"
						maxLength="13" />
				</div>
				<div class="form-row">
					<FormInputText label="Password" v-model="form.password" :error="form.errors.password" />
					<FormInputText label="Confirm Password" v-model="form.password_confirmation"
						:error="form.errors.password_confirmation" />
				</div>
				<div class="form-row">
					<FormInputSelect label="Session Type" v-model="form.sessions_type" :error="form.errors.sessions_type">
						<option value="" selected>Select session type</option>
						<option value="morning">Morning</option>
						<option value="evening">Evening</option>
					</FormInputSelect>
					<FormInputText label="Roll Number(optional)" v-model="form.roll_no" :error="form.errors.roll_no" />
				</div>
				<div class="form-row">
					<FormInputSelect label="Program" v-model="form.program" :error="form.errors.program">
						<option value="" selected>Select program to enroll</option>
						<option v-for="program in programs" :key="program.id" :value="program.id">{{ program.program_name }}
						</option>
					</FormInputSelect>

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
import FormInputSelect from "../../../../components/shared/form/FormInputSelect.vue";

export default {
	components: {
		Link,
		FormInputSelect
	},
	props: {
		programs: {
			required: true,
		}
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
				phone: "",
				sessions_type: "",
				roll_no: "",
				program: ""
			}),
			crumbs: [
				{
					text: "Users",
					route: this.$route("admin.users")
				},
				{
					text: "Student",
					route: this.$route("admin.users", { role: "student" })
				},
				{
					text: "Create"
				}
			]
		};
	},
	methods: {
		store() {
			this.form.post(this.$route("admin.users.student.store"));
		}
	}
};
</script>