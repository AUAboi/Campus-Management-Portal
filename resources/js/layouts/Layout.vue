<template>
	<main class="md:h-screen md:flex md:flex-col">
		<header>
			<div class="md:flex md:flex-shrink-0">
				<div
					class="bg-indigo-900 text-white md:flex-shrink-0 md:w-56 px-6 py-4 flex items-center justify-between md:justify-center"
				>
					<a href="./dashboard" class="mt-1 text-2xl">PORTAL</a>
					<button type="button" class="md:hidden">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 20 20"
							class="fill-white w-6 h-6"
						>
							<path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
						</svg>
						<!---->
					</button>
				</div>
				<div
					class="bg-white border-b w-full p-4 md:py-0 md:px-12 text-sm md:text-md flex justify-between items-center"
				>
					<div class="mt-1 mr-4">{{ appName }}</div>
					<button type="button" class="mt-1">
						<div class="flex items-center cursor-pointer select-none group">
							<div
								class="text-gray-700 group-hover:text-indigo-600 focus:text-indigo-600 mr-1 whitespace-nowrap"
							>
								<span>{{ user.name }}</span>
							</div>
							<svg
								xmlns="http://www.w3.org/2000/svg"
								viewBox="0 0 20 20"
								class="w-5 h-5 group-hover:fill-indigo-600 fill-gray-700 focus:fill-indigo-600"
							>
								<path
									d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
								></path>
							</svg>
						</div>
						<!---->
					</button>
				</div>
			</div>
		</header>
		<div class="md:flex md:flex-grow md:overflow-hidden">
			<nav
				class="hidden md:block bg-indigo-800 text-white flex-shrink-0 w-56 p-12 overflow-y-auto"
			>
				<div class="flex flex-col text-gray-200">
					<Link
						:class="{ 'text-white': $page.url === '/student/dashboard' }"
						class="m-2"
						href="./dashboard"
						>Dashboard</Link
					>
					<Link
						:class="{ 'text-white': $page.url === '/student/profile' }"
						class="m-2"
						href="./profile"
						>Profile</Link
					>
					<Link
						:class="{ 'text-white': $page.url === '/student/course-details' }"
						class="m-2"
						href="./course-details"
						>Course Details</Link
					>
				</div>
			</nav>
			<article
				class="md:flex-1 px-4 py-8 md:p-12 md:overflow-y-auto bg-gray-100"
			>
				<slot />
			</article>
		</div>
	</main>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";

export default {
	components: {
		Link
	},
	computed: {
		user() {
			return this.$page.props.auth.user;
		},
		appName() {
			return this.$page.props.appName;
		}
	}
};
</script>

