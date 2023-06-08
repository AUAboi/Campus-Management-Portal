<script setup>
import FormInputSelect from "@/components/shared/form/FormInputSelect.vue";
import { computed } from "vue";
const props = defineProps({
    modelValue: {
        required: true
    },
    organizations: {
        required: true
    },
    degreeTypes: {
        required: true
    }
});

const emits = defineEmits(["update:modelValue"]);

const form = computed({
    get() {
        return props.modelValue;
    },
    set(val) {
        emits("update:modelValue", val);
    }
});
</script>

<template>
    <div class="form-row">
        <FormInputSelect
            label="Organization"
            :error="form.errors.organization_id"
            v-model="form.organization_id"
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
            v-if="form.type"
            v-model="form.title"
        >
            <option value=""></option>
            <option
                v-for="(title, index) in degreeTypes[form.type]"
                class="capitalize"
                :key="index"
                :value="title"
            >
                {{ title }}
            </option>
        </FormInputSelect>
    </div>
</template>
