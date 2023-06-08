<script setup>
import TheApplicantHead from "../../../components/applicant/meta/TheApplicantHead.vue";
import SelectTypeStep from "./Partials/SelectTypeStep.vue";
import SelectQualificationStep from "./Partials/SelectQualificationStep.vue";
import SelectExamStep from "./Partials/SelectExamStep.vue";

import IconArrowLeft from "~icons/mdi/arrow-left";
import IconArrowRight from "~icons/mdi/arrow-right";
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const props = defineProps({
    organizations: {
        type: Array,
        required: true
    },
    degreeTypes: {
        type: Object,
        required: true
    }
});

const form = useForm({
    type: "",
    organization_id: "",
    title: "",
    exam_type: "",
    reg_no: "",
    passing_year: "",
    obtained_marks: "",
    total_marks: ""
});

const currentStep = ref(1);
const transition = ref("previous");
const animateShake = ref(false);

const nextStep = () => {
    if (!form.type) {
        callToAction();
        return;
    }
    if (!isLastStep.value) {
        transition.value = "next";
        currentStep.value++;
    }
};
const previousStep = () => {
    if (!isFirstStep.value) {
        transition.value = "previous";
        currentStep.value--;
    }
};
const callToAction = () => {
    animateShake.value = true;

    setTimeout(resetAnimation, 1000);
};
const resetAnimation = () => {
    //improve later
    animateShake.value = false;
};
const store = () => {
    form.post(route("applicant.academic-details.store"));
};

const isFirstStep = computed(() => {
    return currentStep.value === 1;
});

const isLastStep = computed(() => {
    return currentStep.value === 3;
});
</script>
<template>
    <div class="flex flex-col gap-8 h-full">
        <TheApplicantHead title="Add Academic details" />
        <div class="h-full">
            <transition-group :name="`slide-${transition}`" mode="out-in">
                <SelectTypeStep
                    :key="currentStep"
                    v-if="currentStep === 1"
                    v-model="form"
                    :degreeTypes="degreeTypes"
                    :animateShake="animateShake"
                />
                <SelectQualificationStep
                    v-if="currentStep === 2"
                    :key="currentStep"
                    class="form"
                    v-model="form"
                    :organizations="organizations"
                    :degreeTypes="degreeTypes"
                />
                <SelectExamStep
                    v-if="currentStep === 3"
                    :key="currentStep"
                    v-model="form"
                    class="form"
                />
            </transition-group>
        </div>

        <div class="mt-4 flex justify-between max-w-3xl">
            <button class="btn-main " v-if="!isFirstStep" @click="previousStep">
                <span class="flex gap-2 items-center">
                    <IconArrowLeft size="18" />
                    Back
                </span>
            </button>
            <button
                class="btn-main ml-auto flex gap-2"
                v-if="!isLastStep"
                @click="nextStep"
            >
                <span class="flex gap-2 items-center">
                    Next
                    <IconArrowRight size="18" />
                </span>
            </button>
            <button
                class="btn-main ml-auto flex gap-2"
                v-if="isLastStep"
                @click.prevent="store"
            >
                <span class="flex gap-2 items-center">
                    Store
                </span>
            </button>
        </div>
    </div>
</template>

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
