<template>
	<div>
		<AppAdminHead title="Create department" />

		<BreadCrumbs :crumbs="crumbs" />

		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form class="m-0" @submit.prevent="store">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Department Name: </label>
						<input
							type="text"
							v-model="form.department_name"
							class="form-input"
						/>
						<div class="text-red-600" v-if="form.errors.department_name">
							{{ form.errors.department_name }}
						</div>
					</div>
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Faculty: </label>
						<select v-model="form.faculty_id" class="form-input">
							<option
								v-for="faculty in faculties"
								:key="faculty.id"
								:value="faculty.id"
								>{{ faculty.faculty_name }}</option
							>
						</select>
						<div class="text-red-600" v-if="form.errors.faculty_id">
							{{ form.errors.faculty_id }}
						</div>
					</div>
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
