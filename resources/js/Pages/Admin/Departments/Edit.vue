<template>
	<div>
		<AppAdminHead :title="form.department_name" />
		<AppBreadCrumbs :crumbs="crumbs" />

		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="update" id="update-form" class="m-0">
				<div class="form-row">
					<FormInputText
						v-model="form.department_name"
						label="Department Name"
						:error="form.errors.department_name"
					/>
					<FormInputSelect
						v-model="form.faculty_id"
						label="Faculty"
						:error="form.errors.faculty_id"
					>
						<option
							v-for="faculty in faculties"
							:key="faculty.id"
							:value="faculty.id"
						>
							{{ faculty.faculty_name }}
						</option>
					</FormInputSelect>
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
import FormInputText from "../../../components/shared/form/FormInputText.vue";
import FormInputSelect from "../../../components/shared/form/FormInputSelect.vue";

import sweetAlert from "../../../mixins/sweetAlert";

export default {
	components: {
		Head,
		Link,
		FormInputText,
		FormInputSelect
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
	mixins: [sweetAlert],
	methods: {
		update() {
			this.form.put(
				this.$route("admin.departments.update", this.department.slug)
			);
		},
		destroy() {
			this.confirmDelete(result => {
				if (result.isConfirmed) {
					this.$inertia.delete(
						this.$route("admin.departments.destroy", this.department.slug)
					);
				}
			});
		}
	}
};
</script>
