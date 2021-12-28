<template>
	<div>
		<article>
			{{ form }}
			<header>
				<div
					:class="{ active: index === formPosition }"
					v-for="(step, index) in formGroup"
					:key="'step' + index"
				>
					{{ index + 1 }}
				</div>
			</header>
			<section :class="animation">
				<h2>{{ formGroup[formPosition].title }}</h2>
				<div>
					<div
						v-for="(field, index) in formGroup[formPosition].fields"
						:key="index"
					>
						<input type="text" v-model="field[Object.keys(field)[1]]" />
					</div>
				</div>
				<div>
					<button v-if="formPosition < formGroup.length - 1" @click="nextStep">
						Next
					</button>
					<button
						@click.prevent="test"
						v-if="formPosition === formGroup.length - 1"
					>
						Enter
					</button>
				</div>
			</section>
		</article>
	</div>
</template>
<script>
export default {
	data() {
		return {
			form: this.$inertia.form({
				name: "",
				father_name: "",
				gender: "",
				email: "",
				password: "",
				cnic: "",
				phone: "",
				role: ""
			}),
			formPosition: 0,
			animation: "animate-in",
			formGroup: [
				{
					title: "Personal Details",
					fields: [
						{ label: "First Name", name: "" },
						{ label: "Second Name", father_name: "" }
					]
				},
				{
					title: "Address",
					fields: [
						{ label: "gender", gender: "" },
						{ label: "email", email: "" }
					]
				},
				{
					title: "Academic Details",
					fields: [
						{ label: "cnic", cnic: "" },
						{ label: "phone", phone: "" },
						{ label: "role", value: "role" }
					]
				}
			]
		};
	},
	methods: {
		test() {},
		nextStep() {
			this.animation = "animate-out";
			setTimeout(() => {
				this.animation = "animate-in";
				this.formPosition += 1;
			}, 600);
		}
	}
};
</script>
<style>
.animation-in {
	transform-origin: left;
	animation: in 0.6s ease-in-out;
}
.animation-out {
	transform-origin: bottom left;
	animation: out 0.6s ease-in-out;
}
</style>