<template>
	<div>
		<TheAdminHead :title="`${application.user.name}'s application`" />
		<AppBreadCrumbs :crumbs="crumbs" />
		<div
			class="bg-white rounded-md shadow overflow-hidden max-w-3xl px-2 py-4 mb-6"
		>
			<h1 class="font-bold text-3xl pb-2">Applicant Details</h1>
			<ul>
				<li>Name: {{ application.user.name }}</li>
				<li>Email: {{ application.user.email }}</li>
				<li>CNIC: {{ application.user.cnic }}</li>
				<li>Phone Number: {{ application.user.phone }}</li>
				<li>Gender: {{ application.user.gender }}</li>
				<li>
					Age:
					{{
						new Date().getFullYear() -
							new Date(application.user.date_of_birth).getFullYear()
					}}
				</li>
			</ul>
		</div>
		<div
			class="bg-white space-y-2 rounded-md shadow overflow-hidden max-w-3xl px-2 py-4 mb-6"
		>
			<h1 class="font-bold text-3xl pb-2">Academic Details</h1>
			<div v-for="detail in application.user.academicDetails" :key="detail.id">
				<h4 class="uppercase text-xs text-gray-600">
					{{ detail.type }}
				</h4>
				<ul>
					<li>
						Title:
						<span class="font-semibold">{{ detail.title }}</span>
					</li>
					<li>
						Registeration Number:
						<span class="font-semibold"> {{ detail.reg_no }} </span>
					</li>
					<li>Passing year: {{ detail.passing_year }}</li>
					<li>From: {{ detail.organization.organization_name }}</li>
					<li>Marks: {{ detail.obtained_marks }}/{{ detail.total_marks }}</li>
				</ul>
			</div>
		</div>
		<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl px-2 py-4">
			<h1 class="font-bold text-3xl pb-2">Application</h1>
			<h4 class="uppercase text-xs text-gray-600">{{ application.status }}</h4>
			<ul>
				<li>
					For:
					<span class="font-semibold"
						>{{ application.program.program_name }} ({{
							application.program.credit_hours
						}}
						credit hours)</span
					>
				</li>
				<li>
					Submitted At:
					<span class="font-semibold"> {{ application.date }} </span>
				</li>
			</ul>
			<div class="flex gap-2 mt-4">
				<form @submit.prevent="approve">
					<AppButton class="bg-green-600" text="Approve" />
				</form>
				<form @submit.prevent="reject">
					<AppButton class="bg-red-600" text="Reject" />
				</form>
			</div>
		</div>
	</div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import TheAdminHead from "../../../components/admin/meta/TheAdminHead.vue";
import AppBreadCrumbs from "../../../components/shared/ui/AppBreadCrumbs.vue";
import AppButton from "../../../components/shared/ui/AppButton.vue";

export default {
	components: { TheAdminHead, AppBreadCrumbs, AppButton },
	data() {
		return {
			crumbs: [
				{
					text: "Applications",
					route: this.$route("admin.applications")
				},
				{
					text: `${this.application.user.name}'s application`
				}
			]
		};
	},
	props: {
		application: {
			required: true
		}
	},
	methods: {
		approve() {
			Inertia.put(
				this.$route("admin.applications.update", {
					application: this.application.id,
					status: "accepted"
				})
			);
		},
		reject() {
			Inertia.put(
				this.$route("admin.applications.update", {
					application: this.application.id,
					status: "rejected"
				})
			);
		}
		
	}
};
</script>

<style>
</style>