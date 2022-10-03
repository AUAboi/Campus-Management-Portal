<template>
	<main>
		<Head :title="`Register your account | ${$page.props.appName}`"></Head>

		<div class="bg-grey-lighter min-h-screen flex flex-col">
			<div
				class="container max-w-sm mx-auto flex-1 flex flex-col items-center justify-center px-2"
			>
				<form class="bg-white px-6 py-8 rounded shadow-md text-black w-full">
					<h1 class="mb-8 text-3xl text-center">Sign up</h1>
					<div v-for="(formStep, step) in steps" :key="step">
						<div v-if="currentStep === step" class="">
							<div v-for="(field, i) in formStep" :key="i">
								<FormInputSelect
									v-if="field.type === 'select'"
									:label="field.label"
									v-model="form[field.key]"
									:error="form.errors[field.key]"
								>
									<option value="">Select {{ field.label }}</option>
									<option
										v-for="(option, index) in field.options"
										:key="index"
										:value="option.value"
										>{{ option.label }}</option
									>
								</FormInputSelect>
								<FormInputText
									v-else
									:label="field.label"
									class="lg:w-full"
									:error="form.errors[field.key]"
									v-model="form[field.key]"
									:type="field.type"
								/>
							</div>
						</div>
					</div>
					<button v-if="isLastStep" class="btn-main">Create Account</button>
					<div class="flex flex-row-reverse gap-2 justify-start mt-5">
						<button
							v-if="!isLastStep"
							class="btn btn-primary"
							@click.prevent="nextStep"
						>
							Next
						</button>
						<button
							v-if="!isFirstStep"
							class="btn"
							@click.prevent="previousStep"
						>
							Previous
						</button>
					</div>
					<div class="text-center text-sm text-grey-dark mt-4">
						By signing up, you agree to the
						<a
							class="no-underline border-b border-grey-dark text-grey-dark"
							href="#"
						>
							Terms of Service
						</a>
						and
						<a
							class="no-underline border-b border-grey-dark text-grey-dark"
							href="#"
						>
							Privacy Policy
						</a>
					</div>
				</form>

				<div class="text-grey-dark mt-6">
					Already have an account?
					<a
						class="no-underline border-b border-blue text-blue"
						href="../login/"
					>
						Log in </a
					>.
				</div>
			</div>
		</div>
	</main>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue";

import FormInputText from "../../../components/shared/form/FormInputText.vue";
import FormInputSelect from "../../../components/shared/form/FormInputSelect.vue";

export default {
	name: "StudentRegister",
	components: { FormInputText, Head, FormInputSelect },
	data() {
		return {
			form: this.$inertia.form({
				name: "",
				father_name: "",
				gender: "",
				email: "",
				date_of_birth: "",
				password: "",
				password_confirmation: "",
				cnic: "",
				phone: ""
			}),
			steps: [
				[
					{
						label: "Email",
						key: "email",
						type: "email"
					},
					{
						label: "Password",
						key: "password",
						type: "password"
					},
					{
						label: "Confirm Password",
						key: "password_confirmation",
						type: "password"
					}
				],
				[
					{
						label: "Name",
						key: "name"
					},
					{
						label: "Father Name",
						key: "father_name"
					},
					{
						label: "Gender",
						key: "gender",
						type: "select",
						options: [
							{
								value: "male",
								label: "Male"
							},
							{
								value: "female",
								label: "Female"
							}
						]
					}
				]
			],
			currentStep: 0
		};
	},
	methods: {
		nextStep() {
			if (this.isLastStep) return;
			this.currentStep++;
		},
		previousStep() {
			if (this.isFirstStep) return;
			this.currentStep--;
		}
	},
	computed: {
		totalSteps() {
			return this.steps.length;
		},
		isFirstStep() {
			return this.currentStep === 0;
		},
		isLastStep() {
			return this.currentStep === this.totalSteps - 1;
		}
	}
};
</script>
