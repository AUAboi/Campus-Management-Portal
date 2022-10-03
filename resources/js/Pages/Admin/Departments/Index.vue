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
				v-if="permissions.create"
				as="button"
				class="btn-main"
				:href="$route('admin.departments.create')"
			>
				<span>Create</span>
				<span class="hidden md:inline">department</span>
			</Link>
		</div>
		<div class="bg-white rounded-md shadow overflow-x-auto">
			<AppDataTable
				:table_data="departments.data"
				:labels="labels"
				route="admin.departments.edit"
			/>
		</div>
		<AppTablePagination class="mt-6" :links="departments.links" />
	</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import AppAdminHead from "../../../components/admin/layouts/AppAdminHead.vue";
import AppTableSearch from "../../../components/shared/tables/AppTableSearch.vue";
import AppTablePagination from "../../../components/shared/tables/AppTablePagination.vue";
import AppDataTable from "../../../components/shared/tables/AppDataTable.vue";

import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";

export default {
	data() {
		return {
			form: {
				search: this.filters.search
			},
			labels: [
				{
					key: "department_name",
					value: "Name"
				},
				{
					key: "faculty_name",
					value: "Faculty"
				}
			]
		};
	},
	components: {
		Link,
		AppAdminHead,
		AppTableSearch,
		AppTablePagination,
		AppDataTable
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
