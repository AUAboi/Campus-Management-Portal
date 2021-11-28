<template>
	<div>
		<AppAdminHead :title="form.faculty_name" />
		<h1 class="mb-8 font-bold text-3xl">
			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.faculties')"
				>Faculites</Link
			>
			<span class="text-indigo-400 font-medium">/</span>
			{{ form.faculty_name }}
		</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="update" id="update-form" class="m-0">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Faculty Name: </label>
						<input
							type="text"
							v-model="form.faculty_name"
							class="form_input"
							:readonly="!permissions.update"
						/>
						<div class="text-red-600" v-if="form.errors.faculty_name">
							{{ form.errors.faculty_name }}
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
							Delete Faculty
						</button>
					</form>

					<button
						v-if="permissions.update"
						form="update-form"
						:disabled="form.processing"
						type="submit"
						class="bg-indigo-500 text-white inline px-4 py-2 cursor-pointer rounded-md"
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
			<table class="w-full whitespace-nowrap">
				<tr class="text-left font-bold">
					<th class="px-6 pt-6 pb-4">Name</th>
				</tr>
				<tr
					v-for="department in faculty.departments"
					:key="department.id"
					class="hover:bg-gray-100 focus-within:bg-gray-100"
				>
					<td class="border-t">
						<Link
							class="px-6 py-4 flex items-center focus:text-indigo-500"
							:href="$route('admin.departments.edit', department.slug)"
						>
							{{ department.department_name }}
						</Link>
					</td>
					<td class="border-t w-px">
						<Link
							class="px-4 flex items-center"
							:href="$route('admin.departments.edit', department.slug)"
							tabindex="-1"
						>
							<i class="fas fa-angle-right text-gray-600"></i
						></Link>
					</td>
				</tr>
				<tr v-if="faculty.departments.length === 0">
					<td class="border-t px-6 py-4" colspan="4">
						No departments found.
					</td>
				</tr>
			</table>
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
			})
		};
	},
	methods: {
		update() {
			this.form.put(this.$route("admin.faculties.update", this.faculty.slug));
		},
		destroy() {
			if (confirm("Are you sure you want to delete this faculty?")) {
				this.$inertia.delete(
					this.$route("admin.faculties.destroy", this.faculty.slug)
				);
			}
		}
	}
};
</script>
