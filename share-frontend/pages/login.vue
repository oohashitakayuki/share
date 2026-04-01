<template>
  <div>

    <p>ログイン</p>

    <form @submit.prevent="login">
      <div>
        <input v-model="email" type="email" placeholder="メールアドレス" />
      </div>
      <div>
        <input v-model="password" type="password" placeholder="パスワード" />
      </div>

      <button type="submit">ログイン</button>
    </form>
  </div>
</template>

<script>
import { auth } from '~/plugins/firebase'

export default {
  layout: 'auth',

  data() {
    return {
      email: '',
      password: ''
    }
  },

  methods: {
    async login() {

      const userCredential = await auth.signInWithEmailAndPassword(
        this.email,
        this.password
      )

      const token = await userCredential.user.getIdToken()

      await this.$axios.post('/api/login')

      this.$router.push('/')
    }
  }
}
</script>