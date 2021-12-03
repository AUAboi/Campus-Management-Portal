<template>
	<div>
		<AppModal modalWidth="w-3xl" @close="show = false" v-if="show">
			<div class="my-6 p-4 grid grid-cols-3 mx-4">
				<Link
					class="p-4"
					:href="$route('admin.programs.courses', [program.slug, 1])"
				>
					Semester 1
				</Link>
				<Link
					class="p-4"
					:href="$route('admin.programs.courses', [program.slug, 2])"
				>
					Semester 2
				</Link>
				<Link
					class="p-4"
					:href="$route('admin.programs.courses', [program.slug, 3])"
				>
					Semester 3
				</Link>
				<Link
					class="p-4"
					:href="$route('admin.programs.courses', [program.slug, 4])"
				>
					Semester 4
				</Link>
				<Link
					class="p-4"
					:href="$route('admin.programs.courses', [program.slug, 5])"
				>
					Semester 5
				</Link>
			</div>
		</AppModal>
		<AppAdminHead
			:title="
				`${program.degree_name}
				${program.department_name}`
			"
		/>
		<h1 class="mb-8 font-bold text-3xl">
			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.departments')"
			>
				{{ program.degree_name }}
				{{ program.department_name }}</Link
			>
			<span class="text-indigo-400 font-medium">/</span>

			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.programs')"
				>Program</Link
			>
			<span class="text-indigo-400 font-medium">/</span>
			{{ program.degree_name }} {{ program.department_name }}
		</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="update" id="update-form" class="m-0">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Degree: </label>
						<select class="form_input" v-model="form.degree_id">
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
						<select class="form_input" v-model="form.department_id">
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
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Credit Hours: </label>
						<input type="text" v-model="form.credit_hours" class="form_input" />
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
			<table class="w-full whitespace-nowrap">
				<tr class="text-left font-bold">
					<th class="px-6 pt-6 pb-4">Name</th>
					<th class="px-6 pt-6 pb-4">Course Code</th>
					<th class="px-6 pt-6 pb-4">Credit Hours</th>
					<th class="px-6 pt-6 pb-4">Semester</th>
					<th class="px-6 pt-6 pb-4"></th>
				</tr>

				<tr
					v-for="course in courses"
					:key="course.id"
					class="hover:bg-gray-100 focus-within:bg-gray-100"
				>
					<td class="border-t">
						<Link
							class="px-6 py-4 flex items-center focus:text-indigo-500"
							:href="$route('admin.courses.edit', course.id)"
						>
							{{ course.course_name }}
						</Link>
					</td>
					<td class="border-t">
						<Link
							class="px-6 py-4 flex items-center focus:text-indigo-500"
							:href="$route('admin.courses.edit', course.id)"
						>
							{{ course.department_code }}-{{ course.course_code }}
						</Link>
					</td>
					<td class="border-t">
						<Link
							class="px-6 py-4 flex items-center focus:text-indigo-500"
							:href="$route('admin.courses.edit', course.id)"
						>
							{{ creditHours(course) }}
						</Link>
					</td>
					<td class="border-t">
						<Link
							class="px-6 py-4 flex items-center focus:text-indigo-500"
							:href="$route('admin.courses.edit', course.id)"
						>
							{{ course.pivot.semester }}
						</Link>
					</td>
					<td class="border-t w-px">
						<Link
							class="px-4 flex items-center"
							:href="$route('admin.courses.edit', course.id)"
							tabindex="-1"
						>
							<i class="fas fa-angle-right text-gray-600"></i
						></Link>
					</td>
				</tr>
				<tr v-if="courses.length === 0">
					<td class="border-t px-6 py-4" colspan="4">
						No courses found.
					</td>
				</tr>
			</table>
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
			show: false
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
		},

		creditHours(course) {
			let hours = course.theory_credit_hours + course.practical_credit_hours;
			return `${hours}(${course.theory_credit_hours}-${course.practical_credit_hours})`;
		}
	}
};
</script>
