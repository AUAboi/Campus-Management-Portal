<template>
	<div>
		<AppAdminHead title="Users" />

		<h1 class="mb-8 font-bold text-3xl">Users</h1>
		<div class="mb-6 flex justify-between items-center">
			<AppTableSearch
				:filterable="true"
				v-model="form.search"
				class="w-full max-w-md mr-4"
				@reset="reset"
			>
				<label class="block text-gray-700">Role:</label>
				<select v-model="form.role" class="mt-1 w-full form-select">
					<option :value="null" />
					<option value="student">Student</option>
					<option value="teacher">Teacher</option>
					<option value="admin">Admin</option>
					<option value="super-admin">Super Admin</option>
				</select>
			</AppTableSearch>

			<Link
				v-if="permissions.create"
				as="button"
				class="bg-indigo-500 text-white inline px-4 py-2 cursor-pointer rounded-md"
				:href="$route('admin.users.create')"
			>
				<span>Create</span>
				<span class="hidden md:inline">User</span>
			</Link>
		</div>
		<div class="bg-white rounded-md shadow overflow-x-auto">
			<table class="w-full whitespace-nowrap">
				<tr class="text-left font-bold">
					<th class="px-6 pt-6 pb-4">Name</th>
					<th class="px-6 pt-6 pb-4">Email</th>
					<th class="px-6 pt-6 pb-4" colspan="2">Role</th>
				</tr>
				<tr
					v-for="user in users"
					:key="user.id"
					class="hover:bg-gray-100 focus-within:bg-gray-100"
				>
					<td class="border-t">
						<Link
							class="px-6 py-4 flex items-center"
							:href="$route('admin.users.show', user.id)"
							tabindex="-1"
						>
							{{ user.name }}
						</Link>
					</td>
					<td class="border-t">
						<Link
							class="px-6 py-4 flex items-center"
							:href="$route('admin.users.show', user.id)"
							tabindex="-1"
						>
							{{ user.email }}
						</Link>
					</td>
					<td class="border-t">
						<span class="px-4 flex items-center">
							{{ user.role }}
						</span>
					</td>
					<td class="border-t w-px">
						<Link
							class="px-4 flex items-center"
							:href="$route('admin.users.show', user.id)"
							tabindex="-1"
						>
							<i class="fas fa-angle-right text-gray-600"></i>
						</Link>
					</td>
				</tr>
				<tr v-if="users.length === 0">
					<td class="border-t px-6 py-4" colspan="4">No users found.</td>
				</tr>
			</table>
		</div>
	</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";

import pickBy from "lodash/pickBy";
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";

export default {
	components: {
		Link
	},
	props: {
		filters: Object,
		users: Array,
		permissions: Object
	},
	data() {
		return {
			form: {
				search: this.filters.search,
				role: this.filters.role
			}
		};
	},
	watch: {
		form: {
			deep: true,
			handler: throttle(function() {
				this.$inertia.get(this.$route("admin.users"), pickBy(this.form), {
					preserveState: true
				});
			}, 150)
		}
	},
	methods: {
		reset() {
			this.form = mapValues(this.form, () => null);
		}
	}
};
</script>