<template>
	<div>
		<TheApplicantHead title="Add Academic details" />
		<!-- <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl"> -->
		{{ form }}
		<div class="h-4/5">
			<transition :name="`slide-${transition}`" mode="out-in">
				<SelectTypeStep class="h-full" :key="currentStep" v-if="currentStep === 1" :form="form"
					:degreeTypes="degreeTypes" :animateShake="animateShake" />
				<div v-if="currentStep === 2" class="bg-white rounded-md shadow max-w-3xl h-full" :key="currentStep">
					<div class="form-row">
						<FormInputSelect v-model="form.organization" label="Organization" :error="form.errors.organization">
							<option v-for="organization in organizations" :key="organization.id" :value="organization.id">{{
								organization.organization_name
							}}</option>
						</FormInputSelect>
						<FormInputSelect label="Qualification Title" :error="form.errors.title" v-model="form.title">
							<option value=""></option>
							<option v-for="(title, index) in degreeTitles" class="capitalize" :key="index" :value="title">{{ title }}
							</option>
						</FormInputSelect>
					</div>
				</div>
				<div v-if="currentStep === 3" class="bg-white rounded-md shadow max-w-3xl h-full" :key="currentStep">
					<div class="form-row">
						<FormInputSelect label="Exam Type" v-model="form.exam_type" :error="form.errors.exam_type">
							<option value=""></option>
							<option value="annual-1st">Annual 1st</option>
							<option value="annual-2nd">Annual 2nd</option>
							<option value="supplementary">Supplementary</option>
						</FormInputSelect>
						<FormInputText label="Registeration/Roll Number" v-model="form.reg_no" :error="form.errors.reg_no" />
					</div>
					<div class="form-row form-row-full">
						<FormInputText type="number" min="1900" max="2099" step="1" v-model="form.passing_year" label="Passing Year"
							:error="form.errors.passing_year" />
						<FormInputText label="Total Marks" v-model="form.total_marks" :error="form.errors.total_marks" />
						<FormInputText label="Obtained Marks" v-model="form.obtained_marks" :error="form.errors.obtained_marks" />
					</div>
					<div v-if="form.total_marks && form.obtained_marks" class="form-row">
						<label class="form-label ">Percentage: {{ percentage }}%</label>
					</div>
				</div>
			</transition>
		</div>

		<div class="mt-4">
			<button class="btn-main" @click="nextStep">Next -></button>
			<button class="btn-main" @click="previousStep">&lt;- Back</button>
		</div>
		<!-- </div> -->
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
			degreeTitles: [],
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
		},
		setTitles(val) {
			if (val === "matric") {
				this.degreeTitles = [
					"Matriculation (Arts)",
					"Matriculation (Science)",
					"O-Levels"
				];
			} else if (val === "intermediate") {
				this.degreeTitles = [
					"FSC (Pre-Medical)",
					"FSC (Pre-Engineering)",
					"ICS"
				];
			}
		},

	},
	watch: {
		"form.type": function (newValue) {
			this.form.title = "";
			this.setTitles(newValue);
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
		SelectTypeStep
	},
	computed: {
		isFirstStep() {
			return this.currentStep === 1;
		},
		isLastStep() {
			return this.currentStep === 3;
		},
		percentage() {
			return ((this.form.obtained_marks / this.form.total_marks) * 100).toFixed(
				2
			);
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



.form-row-full {
	@apply flex-nowrap;
}
</style>