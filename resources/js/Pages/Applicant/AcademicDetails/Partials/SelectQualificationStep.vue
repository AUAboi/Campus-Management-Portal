<template>
  <div class="form-row">
    <FormInputSelect v-model="form.organization" label="Organization" :error="form.errors.organization">
      <option v-for="organization in organizations" :key="organization.id" :value="organization.id">{{
        organization.organization_name
      }}</option>
    </FormInputSelect>
    <FormInputSelect label="Qualification Title" :error="form.errors.title" v-model="form.title" v-if="form.type">
      <option value=""></option>
      <option v-for="(title, index) in degreeTypes[form.type]" class="capitalize" :key="index" :value="title">
        {{ title }}
      </option>
    </FormInputSelect>
  </div>
</template>

<script>
import FormInputSelect from '../../../../components/shared/form/FormInputSelect.vue';

export default {
  props: {
    form: {
      required: true
    },
    organizations: {
      required: true
    },
    degreeTypes: {
      required: true
    }
  },
  components: { FormInputSelect, FormInputSelect }
}
</script>

<style>

</style>