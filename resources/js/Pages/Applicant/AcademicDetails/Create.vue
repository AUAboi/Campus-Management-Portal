<template>
	<div>
		<TheApplicantHead title="Add Academic details" />
		<FormInputSelect
			v-model="form.organization"
			label="Board/Insititution"
			:error="form.organization.error"
		>
			<option value=""></option>
			<option
				v-for="organization in organizations"
				:key="organization.id"
				:value="organization.id"
			>
				{{ organization.organization_name }}
			</option>
		</FormInputSelect>
	</div>
</template>

<script>
import TheApplicantHead from "../../../components/applicant/meta/TheApplicantHead.vue";
import FormInputSelect from "../../../components/shared/form/FormInputSelect.vue";

export default {
	data() {
		return {
			form: this.$inertia.form({
				organization: ""
			})
		};
	},
	props: {
		organizations: {
			type: Array,
			required: true
		}
	},
	components: { TheApplicantHead, FormInputSelect }
};
</script>
