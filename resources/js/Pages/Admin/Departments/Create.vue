<template>
	<div>
		<AppAdminHead title="Create department" />

		<BreadCrumbs :crumbs="crumbs" />

		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form class="m-0" @submit.prevent="store">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<FormInputText
						label="Department Name"
						v-model="form.department_name"
						:error="form.errors.department_name"
						class="pr-6 pb-8 w-full lg:w-1/2"
					/>

					<FormInputSelect
						class="pr-6 pb-8 w-full lg:w-1/2"
						label="Faculty"
						v-model="form.faculty_id"
					>
						<option
							v-for="faculty in faculties"
							:key="faculty.id"
							:value="faculty.id"
							>{{ faculty.faculty_name }}</option
						>
					</FormInputSelect>
				</div>
				<div
					class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center"
				>
					<button :disabled="form.processing" type="submit" class="btn-main">
						Create department
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
	props: {
		faculties: {
			required: true
		}
	},
	data() {
		return {
			form: this.$inertia.form({
				department_name: "",
				faculty_id: ""
			}),

			crumbs: [
				{
					text: "Department",
					route: this.$route("admin.departments")
				},
				{
					text: "Create"
				}
			]
		};
	},
	methods: {
		store() {
			this.form.post(this.$route("admin.departments.store"));
		}
	}
};
</script>
