<template>
	<div class="flex flex-col text-indigo-300">
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('dashboard') }"
				class="m-2"
				:href="$route('admin.dashboard')"
				>Dashboard</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('profile') }"
				class="m-2"
				:href="$route('admin.profile')"
				>Profile</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('faculties') }"
				class="m-2"
				:href="$route('admin.faculties')"
				>Faculties</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('departments') }"
				class="m-2"
				:href="$route('admin.departments')"
				>Departments</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('programs') }"
				class="m-2"
				:href="$route('admin.programs')"
				>Programs</Link
			>
		</div>
		<div class="nav-item">
			<Link
				:class="{ 'text-white': isUrl('courses') }"
				class="m-2"
				:href="$route('admin.courses')"
				>Courses</Link
			>
		</div>
	</div>
</template>

<script>
export default {};
</script>


<style scoped>
.nav-item {
	@apply my-2;
}
</style>