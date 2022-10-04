<template>
	<div>
		<TheAdminHead title="Users" />
		<h1 class="mb-8 font-bold text-3xl">Users</h1>
		<div class="mb-6 flex justify-between items-center">
			<AppTableSearch
				:filterable="true"
				v-model="form.search"
				class="w-full max-w-md mr-4"
				@reset="reset"
			>
				<label class="block text-gray-700">Role:</label>
				<select v-model="form.role" class="mt-1 w-full form-select capitalize">
					<option :value="null" />
					<option
						v-for="role in roles"
						:key="role.id"
						:value="role.name"
						class="capitalize"
					>
						{{ role.name.replace("-", " ") }}
					</option>
				</select>
			</AppTableSearch>
			<AppDropdown v-if="permissions.create" class="mt-1" placement="bottom">
				<div class="flex items-center cursor-pointer select-none group">
					<button class="btn-main">
						<span>Create</span>
						<span class="hidden md:inline">User</span>
						<i
							class="fas fa-chevron-down w-5 h-5 text-white flex align-middle mt-1"
						></i>
					</button>
				</div>
				<div
					slot="dropdown"
					class="mt-2 py-2 shadow-xl bg-white rounded text-sm"
				>
					<div>
						<Link
							class="block px-6 py-2 hover:bg-indigo-500 hover:text-white"
							:href="$route('admin.users.admin.create')"
							>Admin</Link
						>
						<Link
							class="block px-6 py-2 hover:bg-indigo-500 hover:text-white"
							:href="$route('admin.users.teacher.create')"
							>Teacher</Link
						>

						<Link
							class="block px-6 py-2 hover:bg-indigo-500 hover:text-white"
							:href="$route('admin.users.student.create')"
							>Student</Link
						>
					</div>
				</div>
			</AppDropdown>
		</div>
		<div class="bg-white rounded-md shadow overflow-x-auto">
			<AppDataTable
				:table_data="users.data"
				:labels="labels"
				route="admin.users.show"
			/>
		</div>
		<AppTablePagination class="mt-6" :links="users.links" />
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
		users: Object,
		permissions: Object,
		roles: Array
	},
	data() {
		return {
			form: {
				search: this.filters.search,
				role: this.filters.role
			},
			labels: [
				{
					value: "Name",
					key: "name"
				},
				{
					value: "Email",
					key: "email"
				},
				{
					value: "Role",
					key: "role"
				}
			]
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