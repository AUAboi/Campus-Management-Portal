<template>
	<div>
		<TheApplicantHead title="Dashboard" />
		<div v-if="notifications">
			<div v-for="(notification, index) in notifications" :key="index">
				<AppNotificationCard :url="$route('applicant.dashboard')">
					{{ notification.text }}
				</AppNotificationCard>
			</div>
		</div>
	</div>
</template>

<script>
import TheApplicantHead from "../../components/applicant/meta/TheApplicantHead.vue";

const AppNotificationCard = () => ({
	component: import("../../ components/shared/cards/AppNotificationCard.vue")
});

export default {
	props: {
		notifications: {
			required: false
		}
	},
	components: { TheApplicantHead, AppNotificationCard }
};
</script>