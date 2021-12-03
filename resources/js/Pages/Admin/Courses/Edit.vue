<template>
	<div>
		<AppAdminHead :title="form.course_name" />
		<h1 class="mb-8 font-bold text-3xl">
			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.courses')"
				>Faculites</Link
			>
			<span class="text-indigo-400 font-medium">/</span>
			{{ form.course_name }}
		</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="update" id="update-form" class="m-0">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full">
						<label class="block">Course Name: </label>
						<input type="text" v-model="form.course_name" class="form_input" />
						<div class="text-red-600" v-if="form.errors.course_name">
							{{ form.errors.course_name }}
						</div>
					</div>
				</div>
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Practical Credit Hours: </label>
						<input
							type="text"
							v-model="form.practical_credit_hours"
							class="form_input"
						/>
						<div
							class="text-red-600"
							v-if="form.practical_credit_hours.course_name"
						>
							{{ form.errors.practical_credit_hours }}
						</div>
					</div>
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Practical Credit Hours: </label>
						<input
							type="text"
							v-model="form.practical_credit_hours"
							class="form_input"
						/>
						<div
							class="text-red-600"
							v-if="form.practical_credit_hours.course_name"
						>
							{{ form.errors.practical_credit_hours }}
						</div>
					</div>
				</div>
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Department Code: </label>
						<input
							type="text"
							v-model="form.department_code"
							class="form_input"
						/>
						<div class="text-red-600" v-if="form.errors.department_code">
							{{ form.errors.department_code }}
						</div>
					</div>
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Course Code: : </label>
						<input type="text" v-model="form.course_code" class="form_input" />
						<div class="text-red-600" v-if="form.errors.course_code">
							{{ form.errors.course_code }}
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
							Delete course
						</button>
					</form>

					<button
						form="update-form"
						:disabled="form.processing"
						type="submit"
						class="btn-main"
					>
						Update course
					</button>
				</div>
			</form>
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
		course: {
			type: Object,
			required: true
		},
		permissions: {
			type: Object,
			default: () => {
				return {
					delete: false
				};
			}
		}
	},
	data() {
		return {
			form: this.$inertia.form({
				course_name: this.course.course_name,
				practical_credit_hours: this.course.practical_credit_hours,
				theory_credit_hours: this.course.theory_credit_hours,
				department_code: this.course.department_code,
				course_code: this.course.course_code
			})
		};
	},
	methods: {
		update() {
			this.form.put(this.$route("admin.courses.update", this.course.id));
		},
		destroy() {
			if (confirm("Are you sure you want to delete this course?")) {
				this.$inertia.delete(
					this.$route("admin.courses.destroy", this.course.id)
				);
			}
		}
	}
};
</script>
