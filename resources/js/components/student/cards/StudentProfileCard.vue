<template>
	<section class="bg-white rounded-md shadow overflow-hidden max-w-3xl flex">
		<AppUserAvatar :avatar="user.avatar" />
		<div class="px-4">
			<p><span class="font-bold">Name:</span> {{ user.name }}</p>
			<p><span class="font-bold">Father Name:</span> {{ user.father_name }}</p>
			<p><span class="font-bold">Gender: </span> {{ user.gender }}</p>
			<p>
				<span class="font-bold">Date of birth:</span> {{ user.date_of_birth }}
			</p>
			<p>
				<span class="font-bold">Registration No:</span>
				{{ user.enrollments[0].registration_number }}
			</p>
			<p>
				<span class="font-bold">Session:</span>
				{{ session }}

			</p>
			<p>
				<span class="font-bold">Session Type:</span>
				{{ user.enrollments[0].session_type }}
			</p>
			<p>
				<span class="font-bold">Admission Year:</span>
				{{ user.enrollments[0].session_start }}
			</p>
		</div>
	</section>
</template>

<script>
import AppUserAvatar from '../../shared/AppUserAvatar.vue';


export default {
	props: {
		user: {
			required: true
		}
	},
	computed: {
		session() {
			return `
			${this.user.enrollments[0].session_start} - ${this.user.enrollments[0].session_start + (this.user.enrollments[0].program.degree.semesters / 2)}
			`
		}
	},
	components: { AppUserAvatar }
};
</script>

<style>

</style>