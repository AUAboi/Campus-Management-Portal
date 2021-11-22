<template>
	<div>
		<AppAdminHead title="Programs" />

		<h1 class="mb-8 font-bold text-3xl">Programs</h1>
		<div class="mb-6 flex justify-between items-center">
			<AppTableSearch
				v-model="form.search"
				class="w-full max-w-md mr-4"
				@reset="reset"
			/>

			<Link
				as="button"
				class="bg-indigo-500 text-white inline px-4 py-2 cursor-pointer rounded-md"
				:href="$route('admin.programs.create')"
			>
				<span>Create</span>
				<span class="hidden md:inline">Program</span>
			</Link>
		</div>
		<div class="bg-white rounded-md shadow overflow-x-auto">
			<table class="w-full whitespace-nowrap">
				<tr class="text-left font-bold">
					<th class="px-6 pt-6 pb-4">Name</th>
					<th class="px-6 pt-6 pb-4">Department</th>
				</tr>
				<tr
					v-for="program in programs.data"
					:key="program.id"
					class="hover:bg-gray-100 focus-within:bg-gray-100"
				>
					<td class="border-t">
						<Link
							class="px-6 py-4 flex items-center focus:text-indigo-500"
							:href="$route('admin.programs.edit', program.slug)"
						>
							{{ program.program_name }}
						</Link>
					</td>
					<td class="border-t">
						<Link
							class="px-6 py-4 flex items-center focus:text-indigo-500"
							:href="$route('admin.programs.edit', program.slug)"
						>
							{{
								program.department ? program.department.department_name : "NA"
							}}
						</Link>
					</td>
					<td class="border-t w-px">
						<Link
							class="px-4 flex items-center"
							:href="$route('admin.programs.edit', program.slug)"
							tabindex="-1"
						>
							<i class="fas fa-angle-right text-gray-600"></i
						></Link>
					</td>
				</tr>
				<tr v-if="programs.data.length === 0">
					<td class="border-t px-6 py-4" colspan="4">
						No programs found.
					</td>
				</tr>
			</table>
		</div>
		<AppTablePagination class="mt-6" :links="programs.links" />
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
		programs: {
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
				this.$inertia.get(this.$route("admin.programs"), pickBy(this.form), {
					preserveState: true
				});
			}, 150)
		}
	}
};
</script>
