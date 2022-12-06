<template>
	<div>
		<table class="w-full whitespace-nowrap">
			<tr class="text-left font-bold">
				<th v-for="(label, index) in labels" :key="index" class="px-6 pt-6 pb-4">
					{{ label.value }}
				</th>
			</tr>
			<tr v-for="(data, index) in table_data" :key="index" class="hover:bg-gray-100 focus-within:bg-gray-100">
				<td v-for="(label, index) in labels" :key="index" class="border-t">
					<Link class="px-6 py-4 flex items-center focus:text-indigo-500"
						:href="$route(route, data.slug ? data.slug : data.id)">
					{{ getValue(data, label.key) }}
					</Link>
				</td>
				<td class="border-t w-px">
					<Link class="px-4 flex items-center" :href="$route(route, data.slug ? data.slug : data.id)" tabindex="-1">
					<ChevronRightIcon class="text-gray-600" />
					</Link>
				</td>
			</tr>
			<tr v-if="table_data.length === 0">
				<td class="border-t px-6 py-4" colspan="4">No entry found.</td>
			</tr>
		</table>
	</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import { ChevronRightIcon } from "@vue-hero-icons/outline";

export default {
	components: {
		Link,
		ChevronRightIcon
	},
	props: {
		route: {
			type: String,
			required: false
		},
		labels: {
			type: Array,
			required: true
		},
		table_data: {
			type: Array,
			required: true
		}
	},
	methods: {
		getValue(obj, prop) {
			const parts = prop.split('.');
			let thisObj = obj;
			let part = 0;
			while (thisObj = thisObj?.[parts[part++]]) {
				if (part >= parts.length) break;
			}
			return thisObj;
		}
	}
};
</script>
