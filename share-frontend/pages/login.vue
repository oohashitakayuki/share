<template>
  <div>

    <p>ログイン</p>

    <ValidationObserver v-slot="{ invalid }">
      <form @submit.prevent="login">

        <div>
          <ValidationProvider name="メールアドレス" rules="required" v-slot="{ errors }">
            <input v-model="email" type="email" placeholder="メールアドレス" />
            <p>{{ errors[0] }}</p>
          </ValidationProvider>
        </div>

        <div>
          <ValidationProvider name="パスワード" rules="required" v-slot="{ errors }">
            <input v-model="password" type="password" placeholder="パスワード" />
            <p>{{ errors[0] }}</p>
          </ValidationProvider>
        </div>

        <button type="submit" :disabled="invalid">ログイン</button>

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