<template>
	<div>
		<AppAdminHead title="Faculties" />

		<h1 class="mb-8 font-bold text-3xl">Faculties</h1>
		<div class="mb-6 flex justify-between items-center">
			<AppTableSearch
				v-model="form.search"
				class="w-full max-w-md mr-4"
				@reset="reset"
			/>

			<Link
				v-if="permissions.create"
				as="button"
				class="btn-main"
				:href="$route('admin.faculties.create')"
			>
				<span>Create</span>
				<span class="hidden md:inline">faculty</span>
			</Link>
		</div>
		<AppDataTable name="faculties" :labels="labels" :table_data="faculties" />
	</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";

export default {
	data() {
		return {
			labels: [
				{
					key: "faculty_name",
					value: "Name"
				}
			],
			form: {
				search: this.filters.search
			}
		};
	},
	components: {
		Link
	},
	props: {
		filters: {
			type: Object
		},
		faculties: {
			required: false
		},
		permissions: {
			type: Object,
			required: false,
			default: () => ({
				create: false
			})
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
			handler: throttle(function() {
				this.$inertia.get(this.$route("admin.faculties"), pickBy(this.form), {
					preserveState: true
				});
			}, 150)
		}
	}
};
</script>
