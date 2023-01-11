<template>
  <div>

    <TheApplicantHead title="Apply" />
    <AppBreadCrumbs :crumbs="crumbs" />
    <p class="my-1 text-xl">
      Choose program to apply. You can apply a maximum of {{ max_allowed }}
    </p>

    <div class="mb-6 flex justify-between items-center">
      <AppTableSearch v-model="form.search" class="w-full max-w-md mr-4" @reset="reset" />
      <div class="flex items-center cursor-pointer select-none group my-4">
        <button @click.prevent="apply" class="btn-main">
          <span>Apply</span>
        </button>
      </div>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Name</th>

          <th class="px-6 pt-6 pb-4"></th>
        </tr>
        <tr @click="form.program_id = program.id" v-for="program in programs.data" :key="program.id"
          class="hover:bg-gray-100 focus-within:bg-gray-100"
          :class="{ 'bg-indigo-600 text-white hover:bg-indigo-600': form.program_id === program.id }">
          <td class="border-t">
            <label class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ program.program_name }}
            </label>
          </td>
          <td class="border-t w-px">
            <label class=" px-6 py-4 flex items-center ">
              <ChevronRightIcon :class="form.program_id === program.id ? 'text-white' : 'text-gray-600'" />
            </label>
          </td>

        </tr>
        <tr v-if="programs.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">
            No programs found.
          </td>
        </tr>
      </table>
      <AppTablePagination :links="programs.meta.links" />

    </div>
  </div>

</template>

<script>
import { ChevronRightIcon } from '@vue-hero-icons/outline';
import mapValues from 'lodash/mapValues';
import pickBy from 'lodash/pickBy';
import throttle from 'lodash/throttle';
import TheApplicantHead from '../../../components/applicant/meta/TheApplicantHead.vue';
import AppTablePagination from '../../../components/shared/tables/AppTablePagination.vue';
import AppTableSearch from '../../../components/shared/tables/AppTableSearch.vue';
import AppBreadCrumbs from '../../../components/shared/ui/AppBreadCrumbs.vue';
import sweetAlert from '../../../mixins/sweetAlert';
export default {
  data() {
    return {
      form: this.$inertia.form({
        search: '',
        program_id: ''
      }),
      crumbs: [
        {
          text: "Applications",
          route: this.$route("applicant.applications.store")
        },
        {
          text: "Apply"
        }
      ]
    }
  },
  components: { TheApplicantHead, AppBreadCrumbs, ChevronRightIcon, AppTablePagination, AppTableSearch },
  props: {
    programs: {
      required: true
    },
    max_allowed: {
      required: true
    }

  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get(this.$route("applicant.applications.create"), pickBy(this.form), {
          preserveState: true,
          replace: true
        });
      }, 150)
    }
  },
  mixins: [sweetAlert],
  methods: {
    apply() {
      if (!this.form.program_id) {
        this.alertError({ title: 'No program selected', text: 'Select a program to apply' })
        return
      }
      this.form.post(this.$route('applicant.applications.create'))
    },
    reset() {
      this.form = mapValues(this.form, () => null);
    }
  }
}
</script>

