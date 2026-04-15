<template>
  <div>
    <p>コメント</p>

    <Message
      v-if="message"
      :message="message"
      :showDetailButton="false"
    />

    <div>
      <p>コメント</p>

      <div v-if="message.comments">
        <div v-for="comment in message.comments" :key="comment.id">
          <p>{{ comment.user.name }}</p>
          <p>{{ comment.comment }}</p>
        </div>
      </div>

      <div>
        <input v-model="newComment" />
        <button @click="submitComment">コメント</button>
      </div>
    </div>
  </div>
</template>

<script>
import Message from '~/components/Message.vue'

export default {
  middleware:'auth',

  components: {
    Message
  },

  data() {
    return {
      message: null,
      newComment: ''
    }
  },

  async asyncData({ $axios, params }) {
    const res = await $axios.get(`/api/posts/${params.id}`)
    return {
      message: res.data
    }
  },

  methods: {
    async submitComment() {
      if (!this.newComment) return

      try {
        const res = await this.$axios.post('/api/comments', {
          post_id: this.message.id,
          comment: this.newComment
        })

        // 最新のコメントを表示
        this.message.comments.unshift(res.data)

        this.newComment = ''
      } catch (e) {
        console.error(e)
      }
    }
  }
}
</script>