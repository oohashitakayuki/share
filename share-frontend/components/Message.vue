<template>
  <div class="message">
    <div class="message__header">
      <div class="message__user">
        <img src="/icons/profile.png" class="message__user-profile">
        <p class="message__user-name">{{ message.user.name }}</p>
      </div>

      <div class="message__actions">
        <img src="/icons/heart.png" class="message__like-button message__icon" @click="toggleLike">
        <span class="message__like-count">{{ likesCount }}</span>

        <img
          v-if="isMyPost"
          src="/icons/cross.png"
          class="message__delete-button message__icon"
          @click="deletePost"
        />

        <img
          v-if="showDetailButton"
          src="/icons/detail.png"
          class="message__detail-link message__icon"
          @click="goToDetail"
        />
      </div>
    </div>

    <p class="message__text">{{ message.post }}</p>
  </div>
</template>

<script>
import { auth } from '~/plugins/firebase'

export default {
  props: {
    message: Object,
    showDetailButton: {
      type: Boolean,
      default: true
    }
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
    },

    goToDetail() {
      this.$router.push(`/posts/${this.message.id}`)
    }
  }
}
</script>

<style scoped>
.message {
  padding: 10px;
  border-bottom: 1px solid #FFF;
  border-left: 1px solid #FFF;
}

.message__header {
  height: 30px;
  display: flex;
  align-items: center;
}

.message__user {
  display: flex;
  align-items: center;
}

.message__user-profile {
  width: 20px;
  margin-right: 7px;
}

.message__user-name {
  font-weight: bold;
}

.message__actions {
  display: flex;
  align-items: center;
}

.message__icon {
  width: 20px;
  cursor: pointer;
}

.message__like-button,
.message__delete-button {
  margin-left: 10px;
}

.message__detail-link {
  margin-left: 36px;
}

.message__like-count {
  margin-left: 8px;
}

.message__text {
  margin: 3px 0;
  font-size: 15px;
}
</style>