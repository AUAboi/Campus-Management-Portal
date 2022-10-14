<template>
	<div>
		<TheApplicantHead title="Applications" />
		{{ programs }}
	</div>
</template> 

<script>
import TheApplicantHead from "../../../components/applicant/meta/TheApplicantHead.vue";
export default {
	props: {
		programs: {
			type: Array
		}
	},
	components: { TheApplicantHead }
};
</script>
