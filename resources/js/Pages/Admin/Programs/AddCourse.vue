<template>
	<div>
		<TheAdminHead title="Add Courses" />

		<AppBreadCrumbs :crumbs="crumbs" />
		<h3 class="mb-8 font-bold text-3xl">Semester {{ semester }}</h3>
		<div class="flex items-center mb-4">
			<button
				v-if="permissions.update"
				class="btn-main "
				@click.prevent="update"
			>
				Update
			</button>
			<p
				@click="deselectAll"
				class="cursor-pointer ml-3 text-sm text-gray-500 hover:text-gray-700 focus:text-indigo-500"
			>
				Unselect all
			</p>
		</div>

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
					@click="course.belongs_to_program = !course.belongs_to_program"
					class="hover:bg-gray-100 focus-within:bg-gray-100"
				>
					<td class="border-t">
						<label
							for="course"
							class="px-6 py-4 flex items-center focus:text-indigo-500"
						>
							{{ course.course_name }}
						</label>
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
						<span
							v-if="permissions.update"
							class="px-4 flex items-center"
							tabindex="-1"
						>
							<input
								name="course"
								type="checkbox"
								v-model="course.belongs_to_program"
							/>
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
import TheAdminHead from "../../../components/admin/meta/TheAdminHead.vue";
import AppBreadCrumbs from "../../../components/shared/ui/AppBreadCrumbs.vue";

export default {
	components: {
		Link,
		TheAdminHead,
		AppBreadCrumbs
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
				update: false
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
					text: this.program.name,
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
		},
		deselectAll() {
			this.courses.forEach(course => {
				course.belongs_to_program = 0;
			});
		}
	}
};
</script>
