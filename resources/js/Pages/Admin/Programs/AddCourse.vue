<template>
	<div>
		<AppAdminHead title="Courses" />

		<BreadCrumbs :crumbs="crumbs" />
		<h3 class="mb-8 font-bold text-3xl">Semester {{ semester }}</h3>

		<button class="btn-main mb-4" @click.prevent="update">
			Update
		</button>
		<div class="bg-white rounded-md shadow overflow-x-auto">
			<table class="w-full whitespace-nowrap">
				<tr class="text-left font-bold">
					<th class="px-6 pt-6 pb-4">Name</th>
					<th class="px-6 pt-6 pb-4">Course Code</th>
					<th class="px-6 pt-6 pb-4">Credit Hours</th>
					<th class="px-6 pt-6 pb-4"></th>
				</tr>
				<tr
					v-for="course in courses"
					:key="course.id"
					class="hover:bg-gray-100 focus-within:bg-gray-100"
				>
					<td class="border-t">
						<span class="px-6 py-4 flex items-center focus:text-indigo-500">
							{{ course.course_name }}
						</span>
					</td>
					<td class="border-t">
						<span class="px-6 py-4 flex items-center focus:text-indigo-500">
							{{ course.department_code }}-{{ course.course_code }}
						</span>
					</td>
					<td class="border-t">
						<span class="px-6 py-4 flex items-center focus:text-indigo-500">
							{{ course.total_credit_hours }}
						</span>
					</td>
					<td class="border-t w-px">
						<span class="px-4 flex items-center" tabindex="-1">
							<input type="checkbox" v-model="course.belongs_to_program" />
						</span>
					</td>
				</tr>
				<tr v-if="courses.length === 0">
					<td class="border-t px-6 py-4" colspan="4">
						No courses found.
					</td>
				</tr>
			</table>
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
		semester: {
			required: true
		},
		program: {
			required: true,
			type: Object
		},
		courses: {
			required: false
		},
		program_courses: {
			type: Array,
			required: false
		},
		permissions: {
			type: Object,
			required: false,
			default: () => ({
				create: false
			})
		}
	},
	data() {
		return {
			updateForm: this.$inertia.form({
				courses: this.courses
			}),
			crumbs: [
				{
					text: "Program",
					route: this.$route("admin.programs")
				},
				{
					text: "Courses",
					route: this.$route("admin.courses")
				},
				{
					text: "Add"
				}
			]
		};
	},
	methods: {
		update() {
			this.updateForm.put(
				this.$route("admin.programs.courses.store", [
					this.program.slug,
					this.semester
				])
			);
		}
	}
};
</script>
