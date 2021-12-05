<template>
	<div>
		<AppAdminHead title="Create course" />

		<h1 class="mb-8 font-bold text-3xl">
			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.courses')"
				>Courses</Link
			>
			<span class="text-indigo-400 font-medium">/</span> Create
		</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form class="m-0" @submit.prevent="store">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full ">
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
						<div class="text-red-600" v-if="form.errors.practical_credit_hours">
							{{ form.errors.practical_credit_hours }}
						</div>
					</div>
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Theory Credit Hours: </label>
						<input
							type="text"
							v-model="form.theory_credit_hours"
							class="form_input"
						/>
						<div class="text-red-600" v-if="form.errors.theory_credit_hours">
							{{ form.errors.theory_credit_hours }}
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
						<label class="block"
							>Course Code:
							<AppTooltip tooltip="Automatically generate course code"
								>(optional)</AppTooltip
							>:
						</label>
						<input type="text" v-model="form.course_code" class="form_input" />
						<div class="text-red-600" v-if="form.errors.course_code">
							{{ form.errors.course_code }}
						</div>
					</div>
				</div>
				<div
					class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center"
				>
					<button :disabled="form.processing" type="submit" class="btn-main">
						Create course
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
	data() {
		return {
			form: this.$inertia.form({
				course_name: "",
				practical_credit_hours: "",
				theory_credit_hours: "",
				department_code: "",
				course_code: ""
			})
		};
	},
	methods: {
		store() {
			this.form.post(this.$route("admin.courses.store"));
		}
	}
};
</script>
