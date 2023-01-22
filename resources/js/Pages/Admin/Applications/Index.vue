<template>
  <div>
    <TheAdminHead title="Applications" />
    <h1 class="mb-8 font-bold text-3xl">Application</h1>
    <div class="mb-6 flex justify-between items-center">
      <AppTableSearch v-model="form.search" class="w-full max-w-md mr-4" @reset="reset" filterable>
        <label class="block text-gray-700">Degree:</label>
        <select v-model="form.status" class="mt-1 w-full capitalize form-select">
          <option :value="null" />
          <option v-for="status in statuses" :key="status.id" :value="status.status">
            {{ status.status }}
          </option>
        </select>

      </AppTableSearch>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <AppDataTable :labels="labels" :table_data="applications.data" route="admin.applications.show" />
    </div>
    <AppTablePagination class="mt-6" :links="applications.meta.links" />

  </div>
</template> 

<script>
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import throttle from "lodash/throttle";
import TheAdminHead from "../../../components/admin/meta/TheAdminHead.vue";
import AppDataTable from "../../../components/shared/tables/AppDataTable.vue";
import AppTablePagination from "../../../components/shared/tables/AppTablePagination.vue";
import AppTableSearch from "../../../components/shared/tables/AppTableSearch.vue";

export default {
  data() {
    return {
      form: {
        search: "",
        status: ""
      },
      labels: [
        {
          key: "user.name",
          value: "Name"
        },
        {
          key: "program.program_name",
          value: "Program"
        },
        {
          key: "status",
          value: "Status"
        }
      ]
    };
  },
  props: {
    statuses: Array,
    applications: {
      type: Object
    },
  },
  computed: {
    appliedCount() {
      return this.applications.length;
    }
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null);
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get(this.$route("admin.applications"), pickBy(this.form), {
          preserveState: true,
          replace: true
        });
      }, 300)
    }
  },
  components: { AppDataTable, TheAdminHead, AppTablePagination, AppTableSearch }
};
</script>
