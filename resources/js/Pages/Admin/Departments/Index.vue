<template>
	<div>
		<AppAdminHead title="Departments" />

		<h1 class="mb-8 font-bold text-3xl">Departments</h1>
		<div class="mb-6 flex justify-between items-center">
			<AppTableSearch
				v-model="form.search"
				class="w-full max-w-md mr-4"
				@reset="reset"
			/>

			<Link
				as="button"
				class="bg-indigo-500 text-white inline px-4 py-2 cursor-pointer rounded-md"
				:href="$route('admin.departments.create')"
			>
				<span>Create</span>
				<span class="hidden md:inline">department</span>
			</Link>
		</div>
		<div class="bg-white rounded-md shadow overflow-x-auto">
			<table class="w-full whitespace-nowrap">
				<tr class="text-left font-bold">
					<th class="px-6 pt-6 pb-4">Name</th>
					<th class="px-6 pt-6 pb-4">Faculty</th>
				</tr>
				<tr
					v-for="department in departments.data"
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
					<td class="border-t">
						<Link
							class="px-6 py-4 flex items-center focus:text-indigo-500"
							:href="$route('admin.departments.edit', department.slug)"
						>
							{{ department.faculty ? department.faculty.faculty_name : "NA" }}
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
				<tr v-if="departments.data.length === 0">
					<td class="border-t px-6 py-4" colspan="4">
						No departments found.
					</td>
				</tr>
			</table>
		</div>
		<AppTablePagination class="mt-6" :links="departments.links" />
	</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";

export default {
	data() {
		return {
			form: {
				search: this.filters.search
			}
		};
	},
	components: {
		Link
	},
	props: {
		filters: {
			type: Object
		},
		departments: {
			required: false
		},
		permissions: {
			type: Object,
			required: false,
			default: () => ({
				create: false
			})
		}
	},
	methods: {
		reset() {
			this.form = mapValues(this.form, () => null);
		}
	},
	watch: {
		form: {
			deep: true,
			handler: throttle(function() {
				this.$inertia.get(this.$route("admin.departments"), pickBy(this.form), {
					preserveState: true
				});
			}, 150)
		}
	}
};
</script>
