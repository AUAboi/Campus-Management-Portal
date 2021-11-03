<template >
	<div class="nav-item">
		<Link
			:class="{ 'text-white': $page.url.endsWith('faculties') }"
			class="m-2"
			href="./faculties"
			>Faculties</Link
		>
		<portal to="maincontent">
			<slot />
		</portal>
	</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";

export default {
	components: {
		Link
	}
};
</script>