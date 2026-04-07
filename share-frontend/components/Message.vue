<template>
  <div class="message">
    <p>{{ message.user.name }}</p>

    <div class="like-area" @click="toggleLike">
      <img
        src="/icons/heart.png"
        class="like-btn"
      />
      <span>{{ likesCount }}</span>
    </div>

    <img
      v-if="isMyPost"
      src="/icons/cross.png"
      class="delete-btn"
      @click="deletePost"
    />

    <p>{{ message.post }}</p>
  </div>
</template>

<script>
import { auth } from '~/plugins/firebase'

export default {
  props: {
    message: Object
  },

  data() {
    return {
      isLiked: this.message.is_liked,
      likesCount: this.message.likes_count
    }
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
    async toggleLike() {
      if (this.isLiked) {
        // いいね解除
        await this.$axios.delete(`/api/posts/${this.message.id}/unlike`)
        this.isLiked = false
        this.likesCount--
      } else {
        // いいね
        await this.$axios.post(`/api/posts/${this.message.id}/like`)
        this.isLiked = true
        this.likesCount++
      }
    },

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

span {
  color: #FFF;
  }

.like-btn {
  width: 20px;
  cursor: pointer;
}

.delete-btn {
  width: 20px;
  cursor: pointer;
}
</style>