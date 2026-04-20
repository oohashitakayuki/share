<template>
  <div>
    <p>新規登録</p>

    <ValidationObserver v-slot="{ invalid }">
      <form @submit.prevent="register">

        <div>
          <ValidationProvider name="ユーザーネーム" rules="required|max:20" v-slot="{ errors }">
            <input
              v-model="name"
              type="text"
              placeholder="ユーザーネーム"
            />
            <p>{{ errors[0] }}</p>
          </ValidationProvider>
        </div>

        <div>
          <ValidationProvider name="メールアドレス" rules="required|email" v-slot="{ errors }">
            <input
              v-model="email"
              type="email"
              placeholder="メールアドレス"
            />
            <p>{{ errors[0] }}</p>
          </ValidationProvider>
        </div>

        <div>
          <ValidationProvider name="パスワード" rules="required|min:6" v-slot="{ errors }">
            <input
              v-model="password"
              type="password"
              placeholder="パスワード"
            />
            <p>{{ errors[0] }}</p>
          </ValidationProvider>
        </div>

        <button type="submit" :disabled="invalid">新規登録</button>

      </form>
    </ValidationObserver>
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