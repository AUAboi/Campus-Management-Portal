<template>
    <main>
        <TheAdminHead :title="`User ${user.name}`" />
        <h1 class="mb-8 font-bold text-3xl">{{ user.name }}</h1>

        <component :user="user" :is="`${role}-profile-card`"></component>

        <div v-if="permissions.update" class="py-4 my-4  max-w-3xl">
            <Link
                :href="route(`admin.users.${role}.edit`, user.id)"
                class="btn-main"
            >
                Edit
            </Link>
        </div>
    </main>
</template>

<script>
import { Link } from "@inertiajs/vue3";

import TheAdminHead from "../../../components/admin/meta/TheAdminHead.vue";
import AdminProfileCard from "../../../components/admin/AdminProfileCard.vue";
import StudentProfileCard from "../../../components/student/cards/StudentProfileCard.vue";
export default {
    components: {
        Link,
        TheAdminHead,
        AdminProfileCard,
        StudentProfileCard
    },
    props: {
        user: {
            required: true,
            type: Object
        },
        permissions: {
            Object,
            required: false
        }
    },
    computed: {
        role() {
            return this.user.roles[0];
        }
    }
};
</script>
