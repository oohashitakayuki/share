<template>
  <div class="message">
    <p>{{ message.user.name }}</p>
    <p>{{ message.post }}</p>

    <img
      src="/icons/cross.png"
      alt="delete"
      class="delete-btn"
      @click="deletePost"
    />
  </div>
</template>

<script>
export default {
  props: {
    message: Object
  },

  methods: {
    async deletePost() {
      if (!confirm('削除しますか？')) return

      await this.$axios.delete(`/api/posts/${this.message.id}`)

      // 親へ通知（再取得）
      this.$emit('post-deleted')
    }
  }
}
</script>

<style>
body {
  background: #000;
}

p {
  color: #FFF;
}

.delete-btn {
  width: 20px;
  cursor: pointer;
}
</style>