<template>
	<div :class="$attrs.class">
		<label v-if="label" class="form-label">{{ label }}:</label>
		<input
			ref="input"
			v-bind="{ ...$attrs, class: null }"
			class="form-input"
			:class="{ error: error }"
			type="text"
			:value="modelValue"
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
		modelValue: String
	},
	emits: ["update:modelValue"],
	methods: {
		focus() {
			this.$refs.input.focus();
		},
		select() {
			this.$refs.input.select();
		},
		setSelectionRange(start, end) {
			this.$refs.input.setSelectionRange(start, end);
		},

		handleInput(event) {
			this.$emit("update:modelValue", event.target.value);
		}
	}
};
</script>