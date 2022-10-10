<template>
	<div>
		<TheApplicantHead title="Applications" />
		{{ applications }}
	</div>
</template> 

<script>
import TheApplicantHead from "../../../components/applicant/meta/TheApplicantHead.vue";
export default {
	props: {
		applications: {
			type: Array
		}
	},
	components: { TheApplicantHead }
};
</script>
