<template>
  <div class="register-form">

    <p class="register-form__heading">新規登録</p>

    <ValidationObserver v-slot="{ invalid }">
      <form class="register-form__form" @submit.prevent="register">

        <div class="register-form__group">
          <ValidationProvider name="ユーザーネーム" rules="required|max:20" v-slot="{ errors }">
            <input
              v-model="name"
              type="text"
              placeholder="ユーザーネーム"
              class="register-form__input"
            />
            <div class="register-form__error-message">{{ errors[0] }}</div>
          </ValidationProvider>
        </div>

        <div class="register-form__group">
          <ValidationProvider name="メールアドレス" rules="required|email" v-slot="{ errors }">
            <input
              v-model="email"
              type="email"
              placeholder="メールアドレス"
              class="register-form__input"
            />
            <div class="register-form__error-message">{{ errors[0] }}</div>
          </ValidationProvider>
        </div>

        <div class="register-form__group">
          <ValidationProvider name="パスワード" rules="required|min:6" v-slot="{ errors }">
            <input
              v-model="password"
              type="password"
              placeholder="パスワード"
              class="register-form__input"
            />
            <div class="register-form__error-message">{{ errors[0] }}</div>
          </ValidationProvider>
        </div>

        <div class="register-form__button">
          <button
            type="submit"
            class="register-form__button-submit submit-button"
            :disabled="invalid"
          >
          新規登録
          </button>
        </div>

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

<style scoped>
.register-form {
  width: 400px;
  height: 300px;
  margin: 150px 0;
  background: #FFF;
  border-radius: 7px;
  text-align: center;
}

.register-form__heading {
  margin-bottom: 10px;
  font-size: 16px;
  font-weight: bold;
}

.register-form__form {
  display: flex;
  flex-direction: column;
  background: #FFF;
  border-radius: 7px;
}

.register-form__group {
  margin: 0 50px 10px
}

.register-form__input {
  width: 100%;
  padding: 12px;
  font-size: 14px;
  border: 1px solid #000;
  border-radius: 10px;
  outline: none;
}

.register-form__error-message {
  margin: 7px 0 0 12px;
  font-size: 14px;
  color: #FF0000;
  text-align: left;
}

.register-form__button {
  margin-bottom: 15px;
}

.register-form__button-submit {
  padding: 10px 25px;
}
</style>