<template>
	<div class="flex flex-col gap-8 h-full">
		<TheApplicantHead title="Add Academic details" />
		<div class="h-full">
			<transition :name="`slide-${transition}`" mode="out-in">
				<SelectTypeStep :key="currentStep" v-if="currentStep === 1" :form="form" :degreeTypes="degreeTypes"
					:animateShake="animateShake" />
				<SelectQualificationStep v-if="currentStep === 2" :key="currentStep" class="form" :form="form"
					:organizations="organizations" :degreeTypes="degreeTypes" />
				<SelectExamStep v-if="currentStep === 3" :key="currentStep" :form="form" class="form" />
			</transition>
		</div>

		<div class="mt-4 flex justify-between max-w-3xl">
			<button class="btn-main " v-if="!isFirstStep" @click="previousStep">
				<span class="flex gap-2 items-center">
					<ArrowLeftIcon size="18" />
					Back
				</span>

			</button>
			<button class="btn-main ml-auto flex gap-2" v-if="!isLastStep" @click="nextStep">
				<span class="flex gap-2 items-center">
					Next
					<ArrowRightIcon size="18" />
				</span>
			</button>
		</div>
	</div>
</template>

<script>
import TheApplicantHead from "../../../components/applicant/meta/TheApplicantHead.vue";
import FormInputSelect from "../../../components/shared/form/FormInputSelect.vue";
import ChooseDegreeType from "../../../components/applicant/forms/steps/ChooseDegreeType.vue";
import AppButton from "../../../components/shared/ui/AppButton.vue";
import EducationInfo from "../../../components/applicant/forms/steps/EducationInfo.vue";
import FormInputText from "../../../components/shared/form/FormInputText.vue";
import SelectTypeStep from "./Partials/SelectTypeStep.vue";
import SelectQualificationStep from "./Partials/SelectQualificationStep.vue";
import SelectExamStep from "./Partials/SelectExamStep.vue";

import { ArrowRightIcon } from "@vue-hero-icons/outline"
import { ArrowLeftIcon } from "@vue-hero-icons/outline"
export default {
	data() {
		return {
			form: this.$inertia.form({
				type: "",
				organization: "",
				title: "",
				exam_type: "",
				reg_no: "",
				passing_year: "",
				obtained_marks: "",
				total_marks: ""
			}),
			currentStep: 1,
			transition: "previous",
			animateShake: false
		};
	},
	methods: {
		nextStep() {
			if (!this.form.type) {
				this.callToAction()
				return;
			}
			if (!this.isLastStep) {
				this.transition = "next";
				this.currentStep++;
			}
		},
		previousStep() {
			if (!this.isFirstStep) {
				this.transition = "previous";
				this.currentStep--;
			}
		},
		callToAction() {
			this.animateShake = true;

			setTimeout(this.resetAnimation, 1000)
		},
		resetAnimation() {
			//improve later
			this.animateShake = false;
		}

	},
	props: {
		organizations: {
			type: Array,
			required: true
		},
		degreeTypes: {
			type: Object,
			required: true
		},

	},
	components: {
		TheApplicantHead,
		FormInputSelect,
		ChooseDegreeType,
		AppButton,
		EducationInfo,
		FormInputText,
		SelectTypeStep,
		SelectQualificationStep,
		SelectExamStep,
		ArrowRightIcon,
		ArrowLeftIcon
	},
	computed: {
		isFirstStep() {
			return this.currentStep === 1;
		},
		isLastStep() {
			return this.currentStep === 3;
		}
	}
};
</script>
<style scoped>
.slide-next-leave-active,
.slide-previous-leave-active {
	transition: all 300ms ease-out;
}

.slide-next-enter-active,
.slide-previous-enter-active {
	transition: all 1000ms ease-out;
}

.slide-next-enter,
.slide-previous-leave-to {
	transform: translate(100%, 0);
}

.slide-next-leave-to,
.slide-previous-enter {
	transform: translate(-100%, 0);
}

.form {
	@apply bg-white rounded-md shadow max-w-3xl;
}
</style>