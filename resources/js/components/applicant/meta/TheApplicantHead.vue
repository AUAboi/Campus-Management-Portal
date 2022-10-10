
<template>
	<Head :title="title ? `${title} - Applicant` : 'Apply Today - Applicant'">
		<slot />
	</Head>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue";

export default {
	components: {
		Head
	},
	props: {
		title: { type: String, required: false }
	}
};
</script>