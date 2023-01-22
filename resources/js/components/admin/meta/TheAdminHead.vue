
<template>

	<Head :title="title ? `${title} - Admin` : 'CMS - Admin'">
		<slot />
	</Head>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue";
import axios from 'axios';

export default {
	data() {
		return {
			manage_applications: false
		}
	},
	components: {
		Head
	},
	props: {
		title: String
	}
};
</script>