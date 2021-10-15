<template>
	<Layout>
		<Head title="Student - Dashboard" />
		<H1>Welcome, user!</H1>
		<p>Hello welcome to your first Inertia app!</p>
	</Layout>
</template>

<script>
import Layout from "../../layouts/Layout";
import { Head } from "@inertiajs/inertia-vue";

export default {
	components: {
		Head,
		Layout
	}
};
</script>