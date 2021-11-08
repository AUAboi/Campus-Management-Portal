<template>
	<div>
		<AppAdminHead :title="form.department_name" />
		<h1 class="mb-8 font-bold text-3xl">
			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.faculties')"
				>{{ department.faculty_name }}</Link
			>
			<span class="text-indigo-400 font-medium">/</span>

			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.departments')"
				>Departments</Link
			>
			<span class="text-indigo-400 font-medium">/</span>
			{{ form.department_name }}
		</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="update" id="update-form" class="m-0">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Department Name: </label>
						<input
							type="text"
							v-model="form.department_name"
							class="form_input"
						/>
						<div class="text-red-600" v-if="form.errors.department_name">
							{{ form.errors.department_name }}
						</div>
					</div>
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Faculty: </label>
						<select class="form_input" v-model="form.faculty_id">
							<option
								v-for="faculty in faculties"
								:key="faculty.id"
								:value="faculty.id"
							>
								{{ faculty.faculty_name }}
							</option>
						</select>
						<div class="text-red-600" v-if="form.errors.department_name">
							{{ form.errors.department_name }}
						</div>
					</div>
				</div>
				<div
					class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center"
				>
					<form @submit.prevent="destroy" id="delete-from" class="m-0">
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
						form="update-form"
						:disabled="form.processing"
						type="submit"
						class="bg-indigo-500 text-white inline px-4 py-2 cursor-pointer rounded-md"
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
		}
	},
	data() {
		return {
			form: this.$inertia.form({
				department_name: this.department.department_name,
				faculty_id: this.department.faculty_id
			})
		};
	},
	methods: {
		update() {
			this.form.put(
				this.$route("admin.departments.update", this.department.id)
			);
		},
		destroy() {
			if (confirm("Are you sure you want to delete this department?")) {
				this.$inertia.delete(
					this.$route("admin.departments.destroy", this.department.id)
				);
			}
		}
	}
};
</script>
