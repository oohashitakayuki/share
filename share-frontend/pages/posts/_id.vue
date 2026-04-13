<template>
  <div>
    <p>コメント</p>

    <Message
      v-if="message"
      :message="message"
      :showDetailButton="false"
    />
  </div>
</template>

<script>
import Message from '~/components/Message.vue'

export default {
  components: { Message },

  data() {
    return {
      message: null
    }
  },

  async mounted() {
    const id = this.$route.params.id

    const res = await this.$axios.get(`/api/posts/${id}`)
    this.message = res.data
  }
}
</script>