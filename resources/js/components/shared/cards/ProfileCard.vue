<template>
  <section class="bg-white rounded-md shadow overflow-hidden max-w-3xl flex">
    <AppUserAvatar :avatar="image" />
    <slot />
  </section>
</template>

<script>
export default {
  props: {
    image: {
      required: true
    }
  }
};
</script>

<style>

</style>