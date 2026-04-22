<template>
  <aside>
    <nav>
      <ul>
        <li><NuxtLink to="/">ホーム</NuxtLink></li>
        <li><button @click="logout">ログアウト</button></li>
      </ul>
    </nav>

    <ValidationObserver v-slot="{ invalid }">
      <div>
        <ValidationProvider name="投稿内容" rules="required|max:120" v-slot="{ errors }">
          <textarea v-model="post"></textarea>
          <p>{{ errors[0] }}</p>
        </ValidationProvider>

        <button :disabled="invalid" @click="submitPost">シェアする</button>

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

<style>
a {
  color: #FFF;
}
</style>