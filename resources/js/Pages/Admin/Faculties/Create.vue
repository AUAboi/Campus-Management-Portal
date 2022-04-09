<template>
	<div>
		<AppAdminHead title="Create Faculty" />
		<BreadCrumbs :crumbs="crumbs" />
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form class="m-0" @submit.prevent="store">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<FormInputText
						class="pr-6 pb-8 w-full lg:w-1/2"
						v-model="form.faculty_name"
						label="Create Faculty"
						:error="form.errors.faculty_name"
					/>
				</div>
				<div
					class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center"
				>
					<button :disabled="form.processing" type="submit" class="btn-main">
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
			}),

			crumbs: [
				{
					text: "Faculty",
					route: this.$route("admin.faculties")
				},
				{
					text: "Create"
				}
			]
		};
	},
	methods: {
		store() {
			this.form.post(this.$route("admin.faculties.store"));
		}
	}
};
</script>
