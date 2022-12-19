<template>
	<div>
		<TheAdminHead :title="`${program.program_name}`" />
		<AppModal modalWidth="w-3xl" @close="show = false" v-if="show">
			<div class="my-6 p-4 grid grid-cols-3 mx-4">
				<Link v-for="(semester, index) in program.semesters" :key="index" class="m-4"
					:href="$route('admin.programs.courses', [program.slug, semester])">
				Semester {{ semester }}
				</Link>
			</div>
		</AppModal>

		<AppBreadCrumbs :crumbs="crumbs" />

		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="update" id="update-form" class="m-0">
				<div class="form-row">
					<FormInputSelect label="Degree" :error="form.errors.degree_id" v-model="form.degree_id">
						<option v-for="degree in degrees" :key="degree.id" :value="degree.id">
							{{ degree.degree_name }}
						</option>
					</FormInputSelect>

					<FormInputSelect label="Department" :error="form.errors.department_id" v-model="form.department_id">
						<option v-for="department in departments" :key="department.id" :value="department.id">
							{{ department.department_name }}
						</option>
					</FormInputSelect>
				</div>
				<div class="form-row">
					<FormInputText label="Credit Hours" :error="form.errors.credit_hours" v-model="form.credit_hours"
						type="number" min="0" />
				</div>
				<div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
					<form v-if="permissions.delete" @submit.prevent="destroy" id="delete-from" class="m-0">
						<button form="delete-from" :disabled="form.processing" type="submit" class="hover:underline text-red-600 ">
							Delete program
						</button>
					</form>

					<button form="update-form" :disabled="form.processing" type="submit" class="btn-main">
						Update program
					</button>
				</div>
			</form>
		</div>

		<h1 class="my-8 font-bold text-3xl">Courses</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<AppDataTable :table_data="courses" :labels="labels" route="admin.courses.edit" />
		</div>
		<div class="mt-4">
			<Link class="btn-main " @click.prevent="show = true">
			Add Course
			</Link>
		</div>
	</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import TheAdminHead from "../../../components/admin/meta/TheAdminHead.vue";
import AppBreadCrumbs from "../../../components/shared/ui/AppBreadCrumbs.vue";
import FormInputSelect from "../../../components/shared/form/FormInputSelect.vue";
import AppDataTable from "../../../components/shared/tables/AppDataTable.vue";
import FormInputText from "../../../components/shared/form/FormInputText.vue";

import sweetAlert from "../../../mixins/sweetAlert";

const AppModal = () => ({
	component: import("../../../components/shared/modals/AppModal.vue")
});

export default {
	components: {
		Link,
		TheAdminHead,
		AppModal,
		AppBreadCrumbs,
		FormInputSelect,
		AppDataTable,
		FormInputText
	},
	props: {
		program: {
			type: Object,
			required: true
		},
		departments: {
			type: Array,
			required: true
		},
		degrees: {
			type: Array,
			required: true
		},
		permissions: {
			type: Object,
			default: () => {
				return {
					delete: false
				};
			}
		},
		courses: Array
	},
	mixins: [sweetAlert],
	data() {
		return {
			form: this.$inertia.form({
				degree_id: this.program.degree.id,
				department_id: this.program.department.id,
				credit_hours: this.program.credit_hours
			}),
			show: false,
			labels: [
				{
					key: "course_name",
					value: "Name"
				},
				{
					key: "course_code",
					value: "Course Code"
				},
				{
					key: "credit_hours",
					value: "Credit Hours"
				},
				{
					key: "semester",
					value: "Semester"
				}
			],
			crumbs: [
				{
					text: this.program.department.department_name,
					route: this.$route(
						"admin.departments.edit",
						this.program.department.slug
					)
				},
				{
					text: "Program",
					route: this.$route("admin.programs")
				},
				{
					text: this.program.program_name
				}
			]
		};
	},
	methods: {
		update() {
			this.form.put(this.$route("admin.programs.update", this.program.slug));
		},
		destroy() {
			this.confirm(
				result => {
					if (result.isConfirmed) {
						this.$inertia.delete(
							this.$route("admin.programs.destroy", this.program.slug)
						);
					}
				},
				{ title: `Deleting ${this.program.program_name}` }
			);
		}
	}
};
</script>
