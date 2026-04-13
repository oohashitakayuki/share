<template>
  <div>
    <p>ホーム</p>

    <Message
      v-for="msg in messages"
      :key="msg.id"
      :message="msg"
      :showDetailButton="true"
      @post-deleted="fetchPosts"
    />
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
      messages: []
    }
  },

  mounted() {
    this.fetchPosts()

    // サイドバーからイベント受け取る
    this.$root.$on('post-created', this.fetchPosts)
  },

  methods: {
    async fetchPosts() {
      const res = await this.$axios.get('/api/posts')
      console.log(res.data)
      this.messages = res.data
    }
  }
}
</script>