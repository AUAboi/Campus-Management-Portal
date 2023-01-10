<template>
	<div>
		<TheApplicantHead title="Applications" />
		<div class="mb-4">
			<button @click="redirect" v-if="appliedCount < max_allowed" class="btn-main">
				<span>Apply</span>
			</button>
		</div>
		<div class="bg-white rounded-md shadow overflow-x-auto">
			<table class="w-full whitespace-nowrap">
				<tr class="text-left font-bold">
					<th v-for="(label, index) in labels" :key="index" class="px-6 pt-6 pb-4">
						{{ label.value }}
					</th>
				</tr>
				<tr v-for="(data, index) in applications" :key="index" class="hover:bg-gray-100 focus-within:bg-gray-100">
					<td v-for="(label, index) in labels" :key="index" class="border-t">
						<span class="px-6 py-4 flex items-center focus:text-indigo-500 capitalize">
							{{ data[label.key] }}
						</span>
					</td>
				</tr>
				<tr v-if="applications.length === 0">
					<td class="border-t px-6 py-4" colspan="4">
						You haven't submitted any application.
					</td>
				</tr>
			</table>
		</div>

		<div class="bg-white rounded-md shadow px-6 py-4 my-4">
			<p>
				You can apply for {{ max_allowed }} different programs at a time. You
				can apply again if you are rejected.
			</p>

			<p v-if="appliedCount && appliedCount < max_allowed">
				You have applied for {{ appliedCount }}
			</p>
			<p v-else-if="!appliedCount">
				You havent applied for any programs. Apply Today!
			</p>
			<p v-else>
				Max amount applied. Wait for the status to update.
			</p>
		</div>
	</div>
</template> 

<script>
import TheApplicantHead from "../../../components/applicant/meta/TheApplicantHead.vue";
import AppDataTable from "../../../components/shared/tables/AppDataTable.vue";

export default {
	data() {
		return {
			labels: [
				{
					key: "program",
					value: "Program"
				},
				{
					key: "status",
					value: "Status"
				}
			]
		};
	},
	props: {
		user: {
			required: true
		},
		applications: {
			type: Array
		},
		max_allowed: {
			type: Number
		}
	},
	computed: {
		appliedCount() {
			return this.applications.filter(app => {
				return app.status !== "rejected";
			}).length;
		}
	},
	methods: {
		redirect() {
			if (!this.user.academicDetails.length) {
				this.$inertia.get(this.$route('applicant.academic-details.create'))
			} else {
				this.$inertia.get(this.$route('applicant.dashboard'))

			}
		}
	},
	components: { TheApplicantHead, AppDataTable }
};
</script>
