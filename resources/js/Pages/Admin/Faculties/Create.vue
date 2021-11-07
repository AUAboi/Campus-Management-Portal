<template>
	<div>
		<AppAdminHead title="Create Faculty" />

		<h1 class="mb-8 font-bold text-3xl">
			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.faculties')"
				>Faculites</Link
			>
			<span class="text-indigo-400 font-medium">/</span> Create
		</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form class="m-0" @submit.prevent="store">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Faculty Name: </label>
						<input type="text" v-model="form.faculty_name" class="form_input" />
						<div class="text-red-600" v-if="form.errors.faculty_name">
							{{ form.errors.faculty_name }}
						</div>
					</div>
				</div>
				<div
					class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center"
				>
					<button
						:disabled="form.processing"
						type="submit"
						class="bg-indigo-500 text-white inline px-4 py-2 cursor-pointer rounded-md"
					>
						Create Faculty
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
				faculty_name: ""
			})
		};
	},
	methods: {
		store() {
			this.form.post(this.$route("admin.faculties.store"));
		}
	}
};
</script>
