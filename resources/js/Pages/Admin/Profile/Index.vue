<template>
	<main>
		<section class="bg-white rounded-md shadow overflow-hidden max-w-3xl flex">
			<AppUserAvatar :avatar="user.avatar" />
			<div class="p-4">
				<p><span class="font-bold">Name:</span> {{ user.name }}</p>
				<p>
					<span class="font-bold">Father Name:</span> {{ user.father_name }}
				</p>
				<p><span class="font-bold">Gender: </span> {{ user.gender }}</p>
				<p>
					<span class="font-bold">Date of birth:</span> {{ user.date_of_birth }}
				</p>
			</div>
		</section>
	</main>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue";
export default {
	components: {
		Head
	},
	props: {
		user: {
			required: true,
			type: Object
		}
	}
};
</script>