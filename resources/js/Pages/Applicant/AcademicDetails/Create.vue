<template>
	<div>
		<TheApplicantHead title="Add Academic details" />
		<!-- <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl"> -->
		{{ form }}
		<div class="h-4/5">
			<transition :name="`slide-${transition}`" mode="out-in">
				<div class="h-full" :key="currentStep" v-if="currentStep === 1">
					<h1 class="text-center">Select your qualification type</h1>
					<div
						class="flex flex-col justify-center gap-16 mt-8 mx-auto w-max sm:flex-row"
					>
						<div
							v-for="(degreeType, index) in degreeTypes"
							:key="index"
							class="bg-white shadow-lg rounded-lg"
							:class="[
								animateShakeClass,
								form.type === degreeType ? 'tile--selected' : ''
							]"
						>
							<label
								class="w-44 h-44 cursor-pointer text-2xl capitalize flex justify-center items-center"
								:for="index"
								>{{ degreeType }}</label
							>
							<input
								class="hidden"
								:value="degreeType"
								v-model="form.type"
								name="types"
								type="radio"
								:id="index"
							/>
						</div>
					</div>
				</div>
				<div
					v-if="currentStep === 2"
					class="bg-white rounded-md shadow max-w-3xl h-full"
					:key="currentStep"
				>
					<div class="form-row">
						<FormInputSelect
							v-model="form.organization"
							label="Organization"
							:error="form.errors.organization"
						>
							<option
								v-for="organization in organizations"
								:key="organization.id"
								:value="organization.id"
								>{{ organization.organization_name }}</option
							>
						</FormInputSelect>
						<FormInputSelect
							label="Qualification Title"
							:error="form.errors.title"
							v-model="form.title"
						>
							<option value=""></option>
							<option
								v-for="(title, index) in degreeTitles"
								class="capitalize"
								:key="index"
								:value="title"
								>{{ title }}</option
							>
						</FormInputSelect>
					</div>
				</div>
				<div
					v-if="currentStep === 3"
					class="bg-white rounded-md shadow max-w-3xl h-full"
					:key="currentStep"
				>
					<div class="form-row">
						<FormInputSelect
							label="Exam Type"
							v-model="form.exam_type"
							:error="form.errors.exam_type"
						>
							<option value=""></option>
							<option value="annual-1st">Annual 1st</option>
							<option value="annual-2nd">Annual 2nd</option>
							<option value="supplementary">Supplementary</option>
						</FormInputSelect>
						<FormInputText
							label="Registeration/Roll Number"
							v-model="form.reg_no"
							:error="form.errors.reg_no"
						/>
					</div>
					<div class="form-row form-row-full">
						<FormInputText
							type="number"
							min="1900"
							max="2099"
							step="1"
							v-model="form.passing_year"
							label="Passing Year"
							:error="form.errors.passing_year"
						/>
						<FormInputText
							label="Total Marks"
							v-model="form.total_marks"
							:error="form.errors.total_marks"
						/>
						<FormInputText
							label="Obtained Marks"
							v-model="form.obtained_marks"
							:error="form.errors.obtained_marks"
						/>
					</div>
					<div v-if="form.total_marks && form.obtained_marks" class="form-row">
						<label class="form-label ">Percentage: {{ percentage }}%</label>
					</div>
				</div>
			</transition>
		</div>

		<div class="mt-4">
			<button class="btn-main" @click="nextStep">Next -></button>
			<button class="btn-main" @click="previousStep"><- Back</button>
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
			hasSelectedDegree: false,
			animateShake: false
		};
	},
	methods: {
		nextStep() {
			if (!this.hasSelectedDegree) {
				this.callToAction();
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
		callToAction() {
			this.animateShake = true;
		}
	},
	watch: {
		"form.type": function(newValue) {
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
			type: Array,
			required: true
		}
	},
	components: {
		TheApplicantHead,
		FormInputSelect,
		ChooseDegreeType,
		AppButton,
		EducationInfo,
		FormInputText
	},
	computed: {
		isFirstStep() {
			return this.currentStep === 0;
		},
		isLastStep() {
			return this.currentStep === 3;
		},
		percentage() {
			return ((this.form.obtained_marks / this.form.total_marks) * 100).toFixed(
				2
			);
		},

		animateShakeClass() {
			return this.animateShake ? "animateshake" : "";
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

.tile--selected {
	@apply opacity-100 bg-indigo-500 text-white shadow-2xl;
}

.form-row-full {
	@apply flex-nowrap;
}

.animateshake {
	animation: shakeanimation 0.82s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
	transform: translate3d(0, 0, 0);
}
</style>