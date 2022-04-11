<template>
	<div>
		<AppAdminHead :title="form.department_name" />
		<BreadCrumbs :crumbs="crumbs" />

		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="update" id="update-form" class="m-0">
				<div class="form-control">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Department Name: </label>
						<input
							type="text"
							v-model="form.department_name"
							class="form-input"
							:readonly="!permissions.update"
						/>

						<div class="text-red-600" v-if="form.errors.department_name">
							{{ form.errors.department_name }}
						</div>
					</div>
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Faculty: </label>
						<select
							:disabled="!permissions.update"
							class="form-input"
							v-model="form.faculty_id"
						>
							<option
								v-for="faculty in faculties"
								:key="faculty.id"
								:value="faculty.id"
							>
								{{ faculty.faculty_name }}
							</option>
						</select>
						<div class="text-red-600" v-if="form.errors.faculty_id">
							{{ form.errors.faculty_id }}
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
							Delete Department
						</button>
					</form>

					<button
						v-if="permissions.update"
						form="update-form"
						:disabled="form.processing"
						type="submit"
						class="btn-main"
					>
						Update Department
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
		department: {
			type: Object,
			required: true
		},
		faculties: {
			type: Array,
			required: true
		},
		permissions: {
			type: Object,
			default: () => {
				return {
					update: false,
					delete: false
				};
			}
		}
	},
	data() {
		return {
			form: this.$inertia.form({
				department_name: this.department.department_name,
				faculty_id: this.department.faculty_id
			}),

			crumbs: [
				{
					text: this.department.faculty_name,
					route: this.$route("admin.faculties")
				},
				{
					text: "Department",
					route: this.$route("admin.departments")
				},
				{
					text: this.department.department_name
				}
			]
		};
	},
	watch: {
		"form.department_name": function(newValue) {
			this.crumbs[this.crumbs.length - 1].text = newValue;
		}
	},
	methods: {
		update() {
			this.form.put(
				this.$route("admin.departments.update", this.department.slug)
			);
		},
		destroy() {
			if (confirm("Are you sure you want to delete this department?")) {
				this.$inertia.delete(
					this.$route("admin.departments.destroy", this.department.slug)
				);
			}
		}
	}
};
</script>
