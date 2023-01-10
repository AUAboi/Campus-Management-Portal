<template>
  <div>
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
</template>

<script>
import FormInputSelect from '../../../../components/shared/form/FormInputSelect.vue';
import FormInputText from '../../../../components/shared/form/FormInputText.vue';

export default {
  props: {
    form: {
      required: true
    }
  },
  computed: {
    percentage() {
      return ((this.form.obtained_marks / this.form.total_marks) * 100).toFixed(2);
    }
  },
  components: { FormInputSelect, FormInputText }
}
</script>

<style scoped>
.form-row-full {
  @apply flex-nowrap;
}
</style>