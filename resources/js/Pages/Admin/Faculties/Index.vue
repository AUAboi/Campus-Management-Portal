<template>
	<div>
		<h1 class="mb-8 font-bold text-3xl">Faculties</h1>
		<div class="mb-6 flex justify-between items-center">
			<!-- <search-filter
				v-model="form.search"
				class="w-full max-w-md mr-4"
				@reset="reset"
			>
				<label class="block text-gray-700">Trashed:</label>
				<select v-model="form.trashed" class="mt-1 w-full form-select">
					<option :value="null" />
					<option value="with">With Trashed</option>
					<option value="only">Only Trashed</option>
				</select>
			</search-filter> -->
			<Link
				as="button"
				class="bg-indigo-500 text-white inline px-4 py-2 cursor-pointer rounded-md"
				href="./faculties/create"
			>
				<span>Create</span>
				<span class="hidden md:inline">faculty</span>
			</Link>
		</div>
		<div class="bg-white rounded-md shadow overflow-x-auto">
			<table class="w-full whitespace-nowrap">
				<tr class="text-left font-bold">
					<th class="px-6 pt-6 pb-4">Name</th>
				</tr>
				<tr
					v-for="faculty in faculties"
					:key="faculty.id"
					class="hover:bg-gray-100 focus-within:bg-gray-100"
				>
					<td class="border-t">
						<Link
							class="px-6 py-4 flex items-center focus:text-indigo-500"
							href="#"
						>
							{{ faculty.faculty_name }}
						</Link>
					</td>
					<td class="border-t w-px">
						<Link class="px-4 flex items-center" href="#" tabindex="-1"> </Link>
					</td>
				</tr>
				<tr v-if="faculties.length === 0">
					<td class="border-t px-6 py-4" colspan="4">
						No faculties found.
					</td>
				</tr>
			</table>
		</div>
	</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";

export default {
	props: {
		faculties: {
			required: false
		}
	},
	components: {
		Link
	}
};
</script>

<style>
</style>