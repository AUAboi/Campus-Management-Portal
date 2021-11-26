<template>
	<div>
		<AppAdminHead :title="form.course_name" />
		<h1 class="mb-8 font-bold text-3xl">
			<Link
				class="text-indigo-400 hover:text-indigo-600"
				:href="$route('admin.courses')"
				>Faculites</Link
			>
			<span class="text-indigo-400 font-medium">/</span>
			{{ form.course_name }}
		</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="update" id="update-form" class="m-0">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<div class="pr-6 pb-8 w-full lg:w-1/2">
						<label class="block">course Name: </label>
						<input type="text" v-model="form.course_name" class="form_input" />
						<div class="text-red-600" v-if="form.errors.course_name">
							{{ form.errors.course_name }}
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
							Delete course
						</button>
					</form>

					<button
						form="update-form"
						:disabled="form.processing"
						type="submit"
						class="bg-indigo-500 text-white inline px-4 py-2 cursor-pointer rounded-md"
					>
						Update course
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
		course: {
			type: Object,
			required: true
		},
		permissions: {
			type: Object,
			default: () => {
				return {
					delete: false
				};
			}
		}
	},
	data() {
		return {
			form: this.$inertia.form({
				course_name: this.course.course_name
			})
		};
	},
	methods: {
		update() {
			this.form.put(this.$route("admin.courses.update", this.course.id));
		},
		destroy() {
			if (confirm("Are you sure you want to delete this course?")) {
				this.$inertia.delete(
					this.$route("admin.courses.destroy", this.course.id)
				);
			}
		}
	}
};
</script>
