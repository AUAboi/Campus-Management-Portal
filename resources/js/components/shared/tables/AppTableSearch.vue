<template>
	<div class="flex items-center">
		<input
			class="relative w-full px-6 py-3 rounded focus:ring"
			autocomplete="off"
			type="text"
			name="search"
			placeholder="Search…"
			:value="keyword"
			@input="search"
		/>
		<button
			class="ml-3 text-sm text-gray-500 hover:text-gray-700 focus:text-indigo-500"
			type="button"
			@click="$emit('reset')"
		>
			Reset
		</button>
	</div>
</template>

<script>
export default {
	props: {
		keyword: {
			type: String
		}
	},
	methods: {
		search(keyword) {
			this.$emit("input", keyword.target.value);
		}
	}
};
</script>
