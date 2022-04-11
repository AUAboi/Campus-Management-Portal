<template>
	<div>
		<AppAdminHead title="Create program" />

		<h1 class="mb-8 font-bold text-3xl">
			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.programs')"
				>Program</Link
			>
			<span class="text-indigo-400 font-medium">/</span> Create
		</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form class="m-0" @submit.prevent="store">
				<div class="form-control">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Degree: </label>
						<select v-model="form.degree_id" class="form-input">
							<option
								v-for="degree in degrees"
								:key="degree.id"
								:value="degree.id"
								>{{ degree.degree_name }}</option
							>
						</select>
						<div class="text-red-600" v-if="form.errors.degree_id">
							{{ form.errors.degree_id }}
						</div>
					</div>
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Department: </label>
						<select v-model="form.department_id" class="form-input">
							<option
								v-for="department in departments"
								:key="department.id"
								:value="department.id"
								>{{ department.department_name }}</option
							>
						</select>
						<div class="text-red-600" v-if="form.errors.department_id">
							{{ form.errors.department_id }}
						</div>
					</div>
				</div>
				<div class="form-control">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Credit Hours: </label>
						<input type="text" v-model="form.credit_hours" class="form-input" />
						<div class="text-red-600" v-if="form.errors.credit_hours">
							{{ form.errors.credit_hours }}
						</div>
					</div>
				</div>

				<div
					class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center"
				>
					<button :disabled="form.processing" type="submit" class="btn-main">
						Create program
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
		departments: {
			required: true
		},
		degrees: {
			required: true
		}
	},
	data() {
		return {
			form: this.$inertia.form({
				degree_id: "",
				department_id: "",
				credit_hours: ""
			})
		};
	},
	methods: {
		store() {
			this.form.post(this.$route("admin.programs.store"));
		}
	}
};
</script>
