<template>
	<div>
		<AppAdminHead :title="`${program.program_name}`" />
		<AppModal modalWidth="w-3xl" @close="show = false" v-if="show">
			<div class="my-6 p-4 grid grid-cols-3 mx-4">
				<Link
					v-for="(semester, index) in program.semesters"
					:key="index"
					class="m-4"
					:href="$route('admin.programs.courses', [program.slug, semester])"
				>
					Semester {{ semester }}
				</Link>
			</div>
		</AppModal>

		<BreadCrumbs :crumbs="crumbs" />

		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="update" id="update-form" class="m-0">
				<div class="form-control">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Degree: </label>
						<select class="form-input" v-model="form.degree_id">
							<option
								v-for="degree in degrees"
								:key="degree.id"
								:value="degree.id"
							>
								{{ degree.degree_name }}
							</option>
						</select>
						<div class="text-red-600" v-if="form.errors.department_name">
							{{ form.errors.department_name }}
						</div>
					</div>
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Department: </label>
						<select class="form-input" v-model="form.department_id">
							<option
								v-for="department in departments"
								:key="department.id"
								:value="department.id"
							>
								{{ department.department_name }}
							</option>
						</select>
						<div class="text-red-600" v-if="form.errors.department_name">
							{{ form.errors.department_name }}
						</div>
					</div>
				</div>
				<div class="form-control">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Credit Hours: </label>
						<input type="text" v-model="form.credit_hours" class="form-input" />
						<div class="text-red-600" v-if="form.errors.credit_hours">
							{{ form.errors.credit_hours }}
						</div>
					</div>
				</div>
				<div
					class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center"
				>
					<form
						v-if="permissions.delete"
						@submit.prevent="destroy"
						id="delete-from"
						class="m-0"
					>
						<button
							form="delete-from"
							:disabled="form.processing"
							type="submit"
							class="hover:underline text-red-600 "
						>
							Delete program
						</button>
					</form>

					<button
						form="update-form"
						:disabled="form.processing"
						type="submit"
						class="btn-main"
					>
						Update program
					</button>
				</div>
			</form>
		</div>

		<h1 class="my-8 font-bold text-3xl">Courses</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<AppDataTable
				:table_data="courses"
				:labels="labels"
				route="admin.courses.edit"
			/>
		</div>
		<div class="mt-4">
			<Link class="btn-main " @click.prevent="show = true">
				Add Course
			</Link>
		</div>
	</div>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue";

export default {
	components: {
		Head,
		Link
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
	data() {
		return {
			form: this.$inertia.form({
				degree_id: this.program.degree_id,
				department_id: this.program.department_id,
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
					text: this.program.department_name,
					route: this.$route(
						"admin.departments.edit",
						this.program.department_slug
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
			if (confirm("Are you sure you want to delete this program?")) {
				this.$inertia.delete(
					this.$route("admin.programs.destroy", this.program.slug)
				);
			}
		}
	}
};
</script>
