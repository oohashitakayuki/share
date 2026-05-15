<template>
  <div class="home">
    <p class="home__heading">ホーム</p>

    <div class="home__timeline">
      <Message
        v-for="msg in messages"
        :key="msg.id"
        :message="msg"
      />
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

<style scoped>
.home__heading {
  margin: 0;
  padding: 5px 10px;
  font-size: 18px;
  font-weight: bold;
  border-bottom: 1px solid #FFF;
  border-left: 1px solid #FFF;
}
</style>