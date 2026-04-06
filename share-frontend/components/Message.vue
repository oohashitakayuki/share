<template>
  <div class="message">
    <p>{{ message.user.name }}</p>
    <p>{{ message.post }}</p>

    <img
      v-if="isMyPost"
      src="/icons/cross.png"
      class="delete-btn"
      @click="deletePost"
    />
  </div>
</template>

<script>
import { auth } from '~/plugins/firebase'

export default {
  props: {
    message: Object
  },

  computed: {
    isMyPost() {
      const user = auth.currentUser
      if (!user) return false

      // Laravelのuser.idとFirebase UIDを紐付けている前提
      return this.message.user.firebase_uid === user.uid
    }
  },

  methods: {
    async deletePost() {
      if (!confirm('削除しますか？')) return

      await this.$axios.delete(`/api/posts/${this.message.id}`)

      // 親へ通知（再取得）
      this.$root.$emit('post-created')
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