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
  middleware:'auth',

  components: {
    Message
  },

  data() {
    return {
      message: null
    }
  },

  async asyncData({ $axios, params }) {
    const res = await $axios.get(`/api/posts/${params.id}`)
    return {
      message: res.data
    }
  }
}
</script>