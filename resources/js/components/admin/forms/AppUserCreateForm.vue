<template>
	<form id="create-form" class="m-0" @submit.prevent="store">
		<div v-if="formStep === 1">
			<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
				<div class="pr-6 pb-8 w-full lg:w-1/2">
					<label class="block">User Name: </label>
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
			<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
				<div class="pr-6 pb-8 w-full lg:w-1/2">
					<label class="block">Phone Number: </label>
					<input type="text" v-model="form.phone" class="form_input" />
					<div class="text-red-600" v-if="form.errors.phone">
						{{ form.errors.phone }}
					</div>
				</div>
				<div class="pr-6 pb-8 w-full lg:w-1/2">
					<label class="block">CNIC: </label>
					<input
						type="text"
						maxlength="13"
						v-model="form.cnic"
						placeholder="XXXXX-XXXXXXX-X"
						autofocus=""
						class="form_input"
					/>
					<div class="text-red-600" v-if="form.errors.cnic">
						{{ form.errors.cnic }}
					</div>
				</div>
			</div>
			<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
				<div class="pr-6 pb-8 w-full lg:w-1/2">
					<label class="block">Password: </label>
					<input type="text" v-model="form.password" class="form_input" />
					<div class="text-red-600" v-if="form.errors.password">
						{{ form.errors.password }}
					</div>
				</div>
				<div class="pr-6 pb-8 w-full lg:w-1/2">
					<label class="block">Role: </label>
					<select v-model="form.role" class="form_input">
						<option value="student">student</option>
						<option value="teacher">teacher</option>
						<option value="admin">admin</option>
					</select>
					<div class="text-red-600" v-if="form.errors.role">
						{{ form.errors.role }}
					</div>
				</div>
			</div>
		</div>
		<AppUserRoleStep v-else :role="form.role" :formStep="formStep" />
		<div
			class="mt-2 px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center"
		>
			<button
				class=" inline px-4 py-2 cursor-pointer rounded-md"
				:class="
					formStep <= 1
						? 'bg-indigo-200 text-gray-200 cursor-not-allowed'
						: 'bg-indigo-500 text-white'
				"
				:disabled="formStep <= 1"
				@click.prevent="formStep--"
			>
				<i class="fa fa-chevron-left" aria-hidden="true"></i> Go Back
			</button>
			<button
				class=" inline px-4 py-2 cursor-pointer rounded-md"
				:class="
					formStep >= 2 || !form.role
						? 'bg-indigo-200 text-gray-200 cursor-not-allowed'
						: 'bg-indigo-500 text-white'
				"
				:disabled="formStep >= 2 || !form.role"
				@click.prevent="formStep++"
			>
				Add Details <i class="fa fa-chevron-right" aria-hidden="true"></i>
			</button>
		</div>
	</form>
</template>

<script>
export default {
	props: {
		form: {
			required: true,
			type: Object
		}
	},
	data() {
		return {
			formStep: 1
		};
	}
};
</script>

<style>
</style>