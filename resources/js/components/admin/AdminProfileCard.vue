<template>
	<section class="bg-white rounded-md shadow overflow-hidden max-w-3xl flex">
		<AppUserAvatar :avatar="user.avatar" />
		<div class="p-4">
			<p><span class="font-bold">Name:</span> {{ user.name }}</p>
			<p><span class="font-bold">Father Name:</span> {{ user.father_name }}</p>
			<p>
				<span class="font-bold">Gender: </span>
				{{ user.gender ? user.gender : "N/A" }}
			</p>
			<p>
				<span class="font-bold">Date of birth:</span>
				{{ user.date_of_birth ? user.date_of_birth : "N/A" }}
			</p>
		</div>
	</section>
</template>

<script>
import AppUserAvatar from "../shared/AppUserAvatar.vue";
export default {
	props: {
		user: {
			required: true
		}
	},
	components: { AppUserAvatar }
};
</script>