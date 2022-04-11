<template>
	<div :class="$attrs.class">
		<label v-if="label" class="form-label">{{ label }}:</label>
		<input
			v-bind="{ ...$attrs, class: null }"
			class="form-input"
			:class="{ error: error }"
			:type="type"
			:value="value"
			@input="handleInput"
		/>
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
			type: String,
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