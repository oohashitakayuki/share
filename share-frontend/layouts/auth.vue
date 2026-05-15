<template>
  <div class="auth wrapper">
    <AuthHeader />

    <Nuxt />
  </div>
</template>

<script>
import AuthHeader from '~/components/AuthHeader.vue'

export default {
  components: {
    AuthHeader
  }
}
</script>

<style scoped>
.auth {
  display: flex;
  justify-content: center;
}
</style>