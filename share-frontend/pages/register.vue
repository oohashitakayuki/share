<template>
  <div>

    <p>新規登録</p>

    <form @submit.prevent="register">
      <div>
        <input v-model="name" type="text" placeholder="ユーザーネーム" />
      </div>
      <div>
        <input v-model="email" type="email" placeholder="メールアドレス" />
      </div>
      <div>
        <input v-model="password" type="password" placeholder="パスワード" />
      </div>

      <button type="submit">新規登録</button>
    </form>
  </div>
</template>

<script>
import { auth } from '~/plugins/firebase'

export default {
  layout: 'auth',

  data() {
    return {
      name: '',
      email: '',
      password: ''
    }
  },

  methods: {
    async register() {

      // Firebaseユーザー作成
      const userCredential = await auth.createUserWithEmailAndPassword(
        this.email,
        this.password
      )

      const user = userCredential.user

      // displayName保存
      await user.updateProfile({
        displayName: this.name
      })

      // IDトークン取得
      const token = await user.getIdToken()

      // Laravelへ送信
      await this.$axios.post('/api/register', {
        name: this.name,
        email: this.email
      })

      this.$router.push('/')
    }
  }
}
</script>