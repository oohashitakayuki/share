<template>
  <div class="login-form">

    <p class="login-form__heading">ログイン</p>

    <ValidationObserver v-slot="{ invalid }">
      <form @submit.prevent="login" class="login-form__form">

        <div class="login-form__group">
          <ValidationProvider name="メールアドレス" rules="required" v-slot="{ errors }">
            <input
              v-model="email"
              type="email"
              placeholder="メールアドレス"
              class="login-form__input"
            />
            <p class="login-form__error-message">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>

        <div class="login-form__group">
          <ValidationProvider name="パスワード" rules="required" v-slot="{ errors }">
            <input
              v-model="password"
              type="password"
              placeholder="パスワード"
              class="login-form__input"
            />
            <p class="login-form__error-message">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>

        <div class="login-form__button">
          <button
            type="submit"
            class="login-form__button-submit submit-button"
            :disabled="invalid"
          >
          ログイン
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

<style scoped>
.login-form {
  width: 400px;
  height: 240px;
  margin: 150px 0;
  background: #FFF;
  border-radius: 7px;
  text-align: center;
}

.login-form__heading {
  margin-bottom: 10px;
  font-size: 16px;
  font-weight: bold;
}

.login-form__form {
  display: flex;
  flex-direction: column;
  background: #FFF;
  border-radius: 7px;
}

.login-form__group {
  margin: 0 50px 10px
}

.login-form__input {
  width: 100%;
  padding: 12px;
  font-size: 14px;
  border: 1px solid #000;
  border-radius: 10px;
  outline: none;
}

.login-form__error-message {
  margin: 7px 0 0 12px;
  font-size: 14px;
  color: #FF0000;
  text-align: left;
}

.login-form__button {
  margin-bottom: 15px;
}

.login-form__button-submit {
  padding: 10px 25px;
}
</style>