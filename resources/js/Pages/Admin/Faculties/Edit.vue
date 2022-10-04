<template>
	<div>
		<TheAdminHead :title="form.faculty_name" />
		<AppBreadCrumbs :crumbs="crumbs" />
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="update" id="update-form" class="m-0">
				<div class="form-row">
					<FormInputText
						label="Faculty Name"
						v-model="form.faculty_name"
						:readonly="!permissions.update"
						:error="form.errors.faculty_name"
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
							Delete Faculty
						</button>
					</form>

					<button
						v-if="permissions.update"
						form="update-form"
						:disabled="form.processing"
						type="submit"
						class="btn-main"
					>
						Update Faculty
					</button>
				</div>
			</form>
		</div>
		<h1 class="my-8 font-bold text-3xl">
			Departments
		</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<AppDataTable
				route="admin.departments.edit"
				:table_data="faculty.departments"
				:labels="labels"
			/>
		</div>
	</div>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue";
import FormInputText from "../../../components/shared/form/FormInputText.vue";
import AppDataTable from "../../../components/shared/tables/AppDataTable.vue";
import AppBreadCrumbs from "../../../components/shared/ui/AppBreadCrumbs.vue";
import TheAdminHead from "../../../components/admin/meta/TheAdminHead.vue";
import sweetAlert from "../../../mixins/sweetAlert";

export default {
	components: {
		Head,
		Link,
		FormInputText,
		AppDataTable,
		AppBreadCrumbs,
		TheAdminHead
	},
	mixins: [sweetAlert],
	props: {
		faculty: {
			type: Object,
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
				faculty_name: this.faculty.faculty_name
			}),

			labels: [
				{
					key: "department_name",
					value: "Name"
				}
			],

			crumbs: [
				{
					text: "Faculties",
					route: this.$route("admin.faculties")
				},
				{
					text: this.faculty.faculty_name
				}
			]
		};
	},

	//Watching for changes in the form data
	watch: {
		"form.faculty_name": function(newValue) {
			this.crumbs[this.crumbs.length - 1].text = newValue;
		}
	},

	methods: {
		update() {
			this.form.put(this.$route("admin.faculties.update", this.faculty.slug));
		},
		destroy() {
			this.confirm(
				result => {
					if (result.isConfirmed) {
						this.$inertia.delete(
							this.$route("admin.faculties.destroy", this.faculty.slug)
						);
					}
				},
				{ title: `Deleting ${this.faculty.faculty_name}` }
			);
		}
	}
};
</script>
