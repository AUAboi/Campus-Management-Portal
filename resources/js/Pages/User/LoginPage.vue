<template>
	<main class="p-6 bg-indigo-800 min-h-screen flex justify-center items-center">
		<form
			class="bg-white rounded-md py-8 px-6 my-10"
			@submit.prevent="form.post('/login')"
		>
			<div class="my-4">
				<label for="email">Email</label>
				<input name="email" class="block" type="email" v-model="form.email" />
				<div class="text-red-600" v-if="form.errors.email">
					{{ form.errors.email }}
				</div>
			</div>
			<div class="my-4">
				<label for="password">Password</label>
				<input
					name="password"
					class="block"
					type="password"
					v-model="form.password"
				/>
				<div class="text-red-600" v-if="form.errors.password">
					{{ form.errors.password }}
				</div>
			</div>
			<div class="my-4">
				<input type="checkbox" v-model="form.remember" /> Remember Me
				<button
					class="bg-indigo-500 text-white block my-1 px-1 py-2"
					type="submit"
					:disabled="form.processing"
				>
					Login
				</button>
			</div>
		</form>
	</main>
</template>

<script>
export default {
	layout: null,
	data() {
		return {
			form: this.$inertia.form({
				email: null,
				password: null,
				remember: false
			})
		};
	}
};
</script>