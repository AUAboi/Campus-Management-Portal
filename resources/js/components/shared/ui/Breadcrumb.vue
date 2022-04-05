<template>
	<h1 class="mb-8 font-bold text-3xl">
		<span v-for="(crumb, index) in crumbs" :key="index">
			<span v-if="!isLast(index)">
				<Link
					class="text-indigo-400 hover:text-indigo-600"
					:href="crumb.route"
					>{{ crumb.text }}</Link
				>
				<span class="text-indigo-400 font-medium">/</span>
			</span>
			<span v-else>{{ crumb.text }}</span>
		</span>
	</h1>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";

export default {
	components: {
		Link
	},
	props: {
		crumbs: {
			type: Array,
			required: true
		}
	},

	methods: {
		isLast(index) {
			return index === this.crumbs.length - 1;
		}
	}
};
</script>
