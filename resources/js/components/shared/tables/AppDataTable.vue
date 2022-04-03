<template>
	<div>
		<div class="bg-white rounded-md shadow overflow-x-auto">
			<table class="w-full whitespace-nowrap">
				<tr class="text-left font-bold">
					<th
						v-for="(label, index) in labels"
						:key="index"
						class="px-6 pt-6 pb-4"
					>
						{{ label.value }}
					</th>
				</tr>
				<tr
					v-for="data in table_data.data"
					:key="data.id"
					class="hover:bg-gray-100 focus-within:bg-gray-100"
				>
					<td v-for="(label, index) in labels" :key="index" class="border-t">
						<Link
							class="px-6 py-4 flex items-center focus:text-indigo-500"
							:href="$route(`admin.${name}.edit`, data.slug)"
						>
							{{ data[label.key] }}
						</Link>
					</td>
					<td class="border-t w-px">
						<Link
							class="px-4 flex items-center"
							:href="$route(`admin.${name}.edit`, data.slug)"
							tabindex="-1"
						>
							<i class="fas fa-angle-right text-gray-600"></i
						></Link>
					</td>
				</tr>
				<tr v-if="table_data.data.length === 0">
					<td class="border-t px-6 py-4" colspan="4">No {{ name }} found.</td>
				</tr>
			</table>
		</div>
		<AppTablePagination class="mt-6" :links="table_data.links" />
	</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";

export default {
	components: {
		Link
	},
	props: {
		name: {
			type: String,
			required: false
		},
		labels: {
			type: Array,
			required: true
		},
		table_data: {
			type: Object,
			required: true
		},
		permissions: {
			type: Object,
			required: false,
			default: () => ({
				create: false
			})
		}
	}
};
</script>
