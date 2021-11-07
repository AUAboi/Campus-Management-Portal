
<template>
	<Head :title="title ? `${title} - Admin` : 'CMS - Admin'">
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
		title: String
	}
};
</script>