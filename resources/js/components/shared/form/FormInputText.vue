<template>
	<div class="pr-6 pb-8 w-full lg:w-1/2" :class="$attrs.class">
		<label v-if="label" class="form-label">{{ label }}:</label>
		<input v-bind="{ ...$attrs, class: null }" class="form-input" :class="{ error: error }" :type="type" :value="value"
			@input="handleInput" />
		<div v-if="error" class="form-error">{{ error }}</div>
	</div>
</template>

<script>
export default {
	inheritAttrs: false,
	props: {
		type: {
			type: String,
			default: "text"
		},
		error: String,
		label: String,
		value: {
			type: [String, Number],
			default: ""
		}
	},
	methods: {
		handleInput(event) {
			this.$emit("input", event.target.value);
		}
	}
};
</script>

<style scoped>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
	-webkit-appearance: none;
	margin: 0;
}

/* Firefox */
input[type="number"] {
	-moz-appearance: textfield;
}
</style>