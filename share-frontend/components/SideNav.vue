<template>
  <aside class="sidenav">
    <img src="logo.png" class="sidenav__logo">

    <nav class="sidenav__nav">
      <ul class="sidenav__list">
        <li class="sidenav__item">
          <img src="/icons/home.png" class="sidenav__icon">
          <NuxtLink to="/" class="sidenav__link">ホーム</NuxtLink>
        </li>

        <li class="sidenav__item">
          <img src="/icons/logout.png" class="sidenav__icon">
          <button class="sidenav__logout" @click="logout">ログアウト</button>
        </li>
      </ul>
    </nav>

    <p class="sidenav__heading">シェア</p>

    <ValidationObserver v-slot="{ invalid }">
      <div class="sidenav__post">
        <ValidationProvider name="投稿内容" rules="required|max:120" v-slot="{ errors }">
          <textarea v-model="post" class="sidenav__textarea"></textarea>
          <p class="sidenav__error-message">{{ errors[0] }}</p>
        </ValidationProvider>

        <div class="sidenav__button">
          <button
            class="sidenav__button-submit submit-button"
            :disabled="invalid"
            @click="submitPost"
          >
          <img src="/icons/feather.png" class="sidenav__submit-icon">
          シェアする
          </button>
        </div>

      </div>
    </ValidationObserver>
  </aside>
</template>

<script>
import { auth } from '~/plugins/firebase'

export default {
  data() {
    return {
      post: ''
    }
  },

  methods: {
    async logout() {
      await auth.signOut()
      this.$router.push('/login')
    },

    async submitPost() {
      await this.$axios.post('/api/posts', {
        post: this.post
      })

      this.post = ''

      // 親へ通知（再取得）
      this.$emit('post-created')
    }
  }
}
</script>

<style scoped>
.sidenav {
  padding: 13px 30px 0 12px;
}

.sidenav__logo {
  width: 36%;
}

.sidenav__list {
  margin: 10px 0;
}

.sidenav__item {
  margin: 10px 0;
  display: flex;
  align-items: center;
}

.sidenav__icon {
  width: 20px;
}

.sidenav__link {
  margin: 3px 0 0 11px;
  color: #FFF;
  font-size: 15px;
  text-decoration: none;
}

.sidenav__logout {
  margin-left: 5px;
  color: #FFF;
  background: none;
  font-size: 15px;
  border: none;
  cursor: pointer;
}

.sidenav__heading {
  margin: 5px 0;
}

.sidenav__post {
  margin-top: 7px;
}

.sidenav__textarea {
  width: 100%;
  height: 120px;
  font-size: 16px;
  color: #FFF;
  background: transparent;
  border: 1px solid #FFF;
  border-radius: 10px;
  resize: none;
}

.sidenav__error-message {
  margin: 10px 0;
  font-size: 14px;
  color: #FFF;
}

.sidenav__button {
  text-align: right;
}

.sidenav__button-submit {
  padding: 10px;
}

.sidenav__submit-icon {
  width: 18px;
  margin-right: 2px;
}
</style>