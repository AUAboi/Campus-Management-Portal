<template>
  <main>
    <AppAdminHead :title="`${user.name}`" />
    <h1 class="mb-8 font-bold text-3xl">{{ user.name }}</h1>

    <ProfileCard :image="user.avatar">
      <div class="px-4">
        <p><span class="font-bold">Name:</span> {{ user.name }}</p>
        <p><span class="font-bold">Father Name:</span> {{ user.father_name }}</p>
        <p><span class="font-bold">Gender: </span> {{ user.gender }}</p>
        <p>
          <span class="font-bold">Date of birth:</span> {{ user.date_of_birth }}
        </p>
        <p>
          <span class="font-bold">Registration No:</span>
          {{ user.student.registration_number }}
        </p>
        <p>
          <span class="font-bold">Student Session:</span>
          {{ user.student.session_duration }}
        </p>
        <p>
          <span class="font-bold">Session Type:</span>
          {{ user.student.session_type }}
        </p>
        <p>
          <span class="font-bold">Admission Year:</span>
          {{ user.student.admission_year }}
        </p>
      </div>
    </ProfileCard>
    <div v-if="permissions.edit" class="py-4 my-4  max-w-3xl">
      <Link :href="$route(`admin.users.student.edit`, user.id)" class="btn-main">
      Edit
      </Link>
    </div>
  </main>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
export default {
  components: {
    Link
  },
  props: {
    user: {
      required: true,
      type: Object
    },
    permissions: {
      type: Object,
      required: false
    }
  }
};
</script>