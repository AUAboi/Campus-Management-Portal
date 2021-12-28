<template>
	<div>
		<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
			<div class="pr-6 pb-8 w-full lg:w-1/2">
				<label class="block">Name: </label>
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
				<label class="block">Father Name: </label>
				<input type="text" v-model="form.father_name" class="form_input" />
				<div class="text-red-600" v-if="form.errors.father_name">
					{{ form.errors.father_name }}
				</div>
			</div>
			<div class="pr-6 pb-8 w-full lg:w-1/2">
				<label class="block">Gender: </label>
				<select v-model="form.gender" class="form_input">
					<option value="" selected></option>
					<option value="male">Male</option>
					<option value="female">Female</option>
				</select>
				<div class="text-red-600" v-if="form.errors.gender">
					{{ form.errors.gender }}
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