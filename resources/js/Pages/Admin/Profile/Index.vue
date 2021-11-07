<template>
	<main>
		<AppAdminHead title="Profile" />

				<h1 class="mb-8 font-bold text-3xl">{{ user.name }}</h1>

		<section class="bg-white rounded-md shadow overflow-hidden max-w-3xl flex">
			<AppUserAvatar :avatar="user.avatar" />
			<div class="p-4">
				<p><span class="font-bold">Name:</span> {{ user.name }}</p>
				<p>
					<span class="font-bold">Father Name:</span> {{ user.father_name }}
				</p>
				<p>
					<span class="font-bold">Gender: </span>
					{{ user.gender ? user.gender : "NA" }}
				</p>
				<p>
					<span class="font-bold">Date of birth:</span>
					{{ user.date_of_birth ? user.date_of_birth : "NA" }}
				</p>
			</div>
		</section>
	</main>
</template>

<script>
export default {
	props: {
		user: {
			required: true,
			type: Object
		}
	}
};
</script>