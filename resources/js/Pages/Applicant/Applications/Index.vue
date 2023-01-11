<template>
	<div>
		<TheApplicantHead title="Applications" />
		<div class="mb-4">
			<button @click="redirect" v-if="appliedCount < max_allowed" class="btn-main">
				<span>Apply</span>
			</button>
		</div>
		<div class="bg-white rounded-md shadow overflow-x-auto">
			<AppDataTable :labels="labels" :table_data="applications" />

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
import sweetAlert from '../../../mixins/sweetAlert';

export default {
	data() {
		return {
			labels: [
				{
					key: "program.program_name",
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
		},
		canApply: Boolean
	},
	computed: {
		appliedCount() {
			return this.applications.filter(app => {
				return app.status !== "rejected";
			}).length;
		}
	},
	mixins: [sweetAlert],
	methods: {
		redirect() {
			if (!this.canApply) {
				this.confirm(
					result => {
						if (result.isConfirmed)
							this.$inertia.get(this.$route('applicant.academic-details.create'))
					},
					{
						title: `You dont have required academic qualifications added.`,
						text: "Add now?",
						confirmButtonText: "Add now",
						confirmButtonColor: "green"
					}
				);
			} else {
				this.$inertia.get(this.$route('applicant.applications.create'))
			}
		}
	},
	components: { TheApplicantHead, AppDataTable }
};
</script>
