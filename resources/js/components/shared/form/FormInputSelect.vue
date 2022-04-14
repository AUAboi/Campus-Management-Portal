<template>
	<div class="pr-6 pb-8 w-full lg:w-1/2" :class="$attrs.class">
		<label v-if="label" class="form-label">{{ label }}:</label>
		<select
			v-model="selected"
			v-bind="{ ...$attrs, class: null }"
			class="form-select"
			:class="{ error: error }"
		>
			<slot />
		</select>
		<div v-if="error" class="form-error">{{ error }}</div>
	</div>
</template>

<script>
export default {
	inheritAttrs: false,
	props: {
		error: String,
		label: String,
		value: [String, Number, Boolean]
	},
	emits: ["input"],
	data() {
		return {
			selected: this.value
		};
	},
	watch: {
		selected(selected) {
			this.$emit("input", selected);
		}
	}
};
</script>