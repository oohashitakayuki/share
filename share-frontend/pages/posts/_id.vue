<template>
  <div class="post-detail">

    <p class="post-detail__heading">コメント</p>

    <div class="post-detail__message">
      <Message
        v-if="message"
        :message="message"
        :showDetailButton="false"
      />
    </div>

    <div class="comment">

      <p class="comment__heading">コメント</p>

      <div v-if="message.comments" class="comment__list">
        <div
          v-for="comment in message.comments"
          :key="comment.id"
          class="comment__item"
        >
          <div class="comment__user">
            <img src="/icons/profile.png" class="comment__user-profile">
            <p class="comment__user-name">{{ comment.user.name }}</p>
          </div>

          <p class="comment__text">{{ comment.comment }}</p>
        </div>
      </div>

    </div>

    <ValidationObserver v-slot="{ invalid }">
      <div class="comment__form">

        <ValidationProvider
          name="コメント内容"
          rules="required|max:120"
          v-slot="{ errors }"
        >
          <input
            v-model="newComment"
            class="comment__input"
          />
          <p class="comment__error-message">{{ errors[0] }}</p>
        </ValidationProvider>

        <div class="comment__button">
          <button
            class="comment__button-submit submit-button"
            :disabled="invalid"
            @click="submitComment"
          >
          コメント
          </button>
        </div>

      </div>
    </ValidationObserver>

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

        this.newComment = ''
      } catch (e) {
        console.error(e)
      }
    }
  }
}
</script>

<style scoped>
.post-detail__heading {
  margin: 0;
  padding: 5px 10px;
  font-size: 18px;
  font-weight: bold;
  border-bottom: 1px solid #FFF;
  border-left: 1px solid #FFF;
}

.comment__heading {
  margin: 0;
  padding: 5px;
  font-size: 15px;
  border-bottom: 1px solid #FFF;
  border-left: 1px solid #FFF;
  text-align: center;
}

.comment__item {
  padding: 10px;
  border-bottom: 1px solid #FFF;
  border-left: 1px solid #FFF;
}

.comment__user {
  height: 30px;
  display: flex;
  align-items: center;
}

.comment__user-profile {
  width: 20px;
  margin-right: 7px;
}

.comment__user-name {
  font-weight: bold;
}

.comment__text {
  margin: 3px 0;
  font-size: 15px;
}

.comment__form {
  margin: 20px 0 0 10px;
}

.comment__input {
  width: 96%;
  padding: 7px;
  font-size: 16px;
  color: #FFF;
  background: transparent;
  border: 1px solid #FFF;
  border-radius: 12px;
}

.comment__button {
  text-align: right;
}

.comment__button-submit {
  padding: 10px 25px;
}

.comment__error-message {
  margin: 12px 0;
  font-size: 14px;
  color: #FFF;
}
</style>