<template>
  <div class="common wrapper">
    <SideNav class="common__sidenav" @post-created="handlePostCreated" />

    <main class="common__content">
      <Nuxt />
    </main>
  </div>
</template>

<script>
import SideNav from '~/components/SideNav.vue'

export default {
  components: {
    SideNav
  },

  methods: {
    handlePostCreated() {
      // 全体に通知
      this.$root.$emit('post-created')
    }
  }
}
</script>

<style scoped>
.common {
  display: flex;
  color: #FFF;
}

.common__sidenav {
  width: 360px;
}

.common__content {
  width: 100%;
}
</style>