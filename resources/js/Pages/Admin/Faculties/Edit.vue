<template>
	<div>
		<h1 class="mb-8 font-bold text-3xl">
			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.faculties')"
				>Faculites</Link
			>
			<span class="text-indigo-400 font-medium">/</span>
			{{ faculty.faculty_name }}
		</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="update">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">Faculty Name: </label>
						<input
							type="text"
							v-model="form.faculty_name"
							class="border-2 border-gray-300 w-full p-2 my-1"
						/>
					</div>
				</div>
				<div
					class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center"
				>
					<button class="hover:underline text-red-600 " @click="destroy">
						Delete Faculty
					</button>
					<button
						:disabled="form.processing"
						type="submit"
						class="bg-indigo-500 text-white inline px-4 py-2 cursor-pointer rounded-md"
					>
						Update Organization
					</button>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";

export default {
	metaInfo() {
		return { title: this.form.faculty_name };
	},
	components: {
		Link
	},
	props: {
		faculty: {
			type: Object,
			required: true
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
			this.form.put(this.$route("admin.faculties.update", this.faculty.id));
		},
		destroy() {
			if (confirm("Are you sure you want to delete this faculty?")) {
				this.$inertia.delete(
					this.$route("admin.faculties.destroy", this.faculty.id)
				);
			}
		}
	}
};
</script>
