<template>
	<section class="bg-white rounded-md shadow overflow-hidden max-w-3xl flex">
		<AppUserAvatar :avatar="user.avatar" />
		<div class="p-1">
			<p><span class="font-bold">Name:</span> {{ user.name }}</p>
			<p><span class="font-bold">Father Name:</span> {{ user.father_name }}</p>
			<p><span class="font-bold">Gender: </span> {{ user.gender }}</p>
			<p>
				<span class="font-bold">Date of birth:</span> {{ user.date_of_birth }}
			</p>
			<p>
				<span class="font-bold">Registration No:</span>
				{{ user.student.registration_number }}
			</p>
			<p>
				<span class="font-bold">Student Session:</span>
				{{ user.student.session_duration }}
			</p>
			<p>
				<span class="font-bold">Session Type:</span>
				{{ user.student.session_type }}
			</p>
			<p>
				<span class="font-bold">Admission Year:</span>
				{{ user.student.admission_year }}
			</p>
		</div>
	</section>
</template>

<script>
export default {
	props: {
		user: {
			required: true
		}
	}
};
</script>

<style>
</style>