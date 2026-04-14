<template>
  <div class="message">
    <p>{{ message.user.name }}</p>

    <img
      src="/icons/heart.png"
      class="like-btn"
      @click="toggleLike"
    />
    <span>{{ likesCount }}</span>

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
      liked: this.message.is_liked,
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
      if (this.liked) {
        // いいね解除
        await this.$axios.delete('/api/unlikes', {
          data: { post_id: this.message.id }
        })
        this.likesCount--
      } else {
        // いいね
        await this.$axios.post('/api/likes', {
          post_id: this.message.id
        })
        this.likesCount++
      }

      this.liked = !this.liked
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

.detail-btn {
  width: 20px;
  cursor: pointer;
}
</style>