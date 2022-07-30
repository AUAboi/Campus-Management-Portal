<template>
	<div>
		<AppAdminHead :title="form.name" />
		<BreadCrumbs :crumbs="crumbs" />

		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="update" id="update-form" class="m-0">
				<div class="form-row">
					<FormInputText
						label="User Name"
						v-model="form.name"
						:error="form.errors.name"
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
							Delete user
						</button>
					</form>

					<button
						form="update-form"
						:disabled="form.processing"
						type="submit"
						class="btn-main"
					>
						Update user
					</button>
				</div>
			</form>
		</div>
		<h1 class="my-8 font-bold text-3xl">
			Faculties
		</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<table class="w-full whitespace-nowrap">
				<tr class="text-left font-bold">
					<th class="px-6 pt-6 pb-4">Faculty</th>
				</tr>
				<tr
					v-for="faculty in user.faculties"
					:key="faculty.id"
					class="hover:bg-gray-100 focus-within:bg-gray-100"
				>
					<td class="border-t">
						<span class="px-6 py-4 flex items-center" tabindex="-1">
							{{ faculty.faculty_name }}
						</span>
					</td>
					<td class="border-t">
						<span class="px-6 py-4 flex items-center" tabindex="-1">
							<input type="checkbox" v-model="faculty.owns_faculty" />
						</span>
					</td>
				</tr>
			</table>
		</div>
		<h1 class="my-8 font-bold text-3xl">
			Permissions
		</h1>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
			<table class="w-full whitespace-nowrap">
				<tr class="text-left font-bold">
					<th class="px-6 pt-6 pb-4">Name</th>
					<th class="px-6 pt-6 pb-4">Create</th>
					<th class="px-6 pt-6 pb-4">Edit</th>
					<th class="px-6 pt-6 pb-4">Delete</th>
				</tr>
				<tr class="hover:bg-gray-100 focus-within:bg-gray-100">
					<td class="border-t">
						<span class="px-6 py-4 flex items-center" tabindex="-1">
							Faculty
						</span>
					</td>
					<td class="border-t">
						<span class="px-6 py-4 flex items-center" tabindex="-1">
							<input
								type="checkbox"
								v-model="user.permissions.create_faculties"
							/>
						</span>
					</td>
					<td class="border-t">
						<span class="px-6 py-4 flex items-center" tabindex="-1">
							<input
								type="checkbox"
								v-model="user.permissions.update_faculties"
							/>
						</span>
					</td>
					<td class="border-t">
						<span class="px-6 py-4 flex items-center" tabindex="-1">
							<input
								type="checkbox"
								v-model="user.permissions.delete_faculties"
							/>
						</span>
					</td>
				</tr>
				<tr class="hover:bg-gray-100 focus-within:bg-gray-100">
					<td class="border-t">
						<span class="px-6 py-4 flex items-center" tabindex="-1">
							User
						</span>
					</td>
					<td class="border-t">
						<span class="px-6 py-4 flex items-center" tabindex="-1">
							<input type="checkbox" v-model="user.permissions.create_users" />
						</span>
					</td>
					<td class="border-t">
						<span class="px-6 py-4 flex items-center" tabindex="-1">
							<input type="checkbox" v-model="user.permissions.update_users" />
						</span>
					</td>
					<td class="border-t">
						<span class="px-6 py-4 flex items-center" tabindex="-1">
							<input type="checkbox" v-model="user.permissions.delete_users" />
						</span>
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
		user: {
			type: Object,
			required: true
		},
		permissions: {
			type: Object,
			required: true
		},
		faculties: Array
	},
	data() {
		return {
			form: this.$inertia.form({
				name: this.user.name,
				permissions: this.user.permissions,
				faculties: this.user.faculties
			}),

			crumbs: [
				{
					text: "Users",
					route: this.$route("admin.users")
				},
				{
					text: this.user.name
				}
			]
		};
	},
	watch: {
		"form.name": function(newValue) {
			this.crumbs[this.crumbs.length - 1].text = newValue;
		}
	},
	methods: {
		update() {
			this.form.put(this.$route("admin.users.admin.update", this.user.id));
		},
		destroy() {
			if (confirm("Are you sure you want to delete this user?")) {
				this.$inertia.delete(this.$route("admin.users.destroy", this.user.id));
			}
		}
	}
};
</script>
