<template>
	<div>
		<AppAdminHead :title="form.course_name" />
		<BreadCrumbs :crumbs="crumbs" />

		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="update" id="update-form" class="m-0">
				<div class="form-row">
					<FormInputText
						class="lg:w-full"
						label="Course Name"
						v-model="form.course_name"
						:error="form.errors.course_name"
					/>
				</div>
				<div class="form-row">
					<FormInputText
						label="Theory Credit Hours"
						v-model="form.theory_credit_hours"
						:error="form.errors.theory_credit_hours"
						type="number"
						max="99"
						min="0"
					/>
					<FormInputText
						label="Practical Credit Hours"
						v-model="form.practical_credit_hours"
						:error="form.errors.practical_credit_hours"
						type="number"
						max="99"
						min="0"
					/>
				</div>
				<div class="form-row">
					<FormInputText
						label="Department Code"
						v-model="form.department_code"
						:error="form.errors.department_code"
					/>

					<FormInputText
						label="Course Code"
						v-model="form.course_code"
						:error="form.errors.course_code"
						type="number"
						max="999"
						min="0"
					/>
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
export default {
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
			}),

			crumbs: [
				{
					text: "Faculties",
					route: this.$route("admin.faculties")
				},
				{
					text: this.course.course_name
				}
			]
		};
	},
	watch: {
		"form.course_name": function(newValue) {
			this.crumbs[this.crumbs.length - 1].text = newValue;
		}
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
