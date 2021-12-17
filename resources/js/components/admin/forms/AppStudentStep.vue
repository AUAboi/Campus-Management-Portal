<template>
	<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
		<div class="pr-6 pb-8 w-full lg:w-1/2">
			<label class="block">Student Name: </label>
			<input type="text" v-model="form.name" class="form_input" />
			<div class="text-red-600" v-if="form.errors.name">
				{{ form.errors.name }}
			</div>
		</div>
		<div class="pr-6 pb-8 w-full lg:w-1/2">
			<label class="block">Email: </label>
			<input type="text" v-model="form.email" class="form_input" />
			<div class="text-red-600" v-if="form.errors.email">
				{{ form.errors.email }}
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		form: {
			type: Object,
			required: true
		}
	}
};
</script>

<style>
</style>