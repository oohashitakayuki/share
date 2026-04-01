<template>
  <div>
    <SideNav @post-created="handlePostCreated" />

    <main>
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