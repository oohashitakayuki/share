<template>
  <aside>
    <nav>
      <ul>
        <li><NuxtLink to="/">ホーム</NuxtLink></li>
        <li><button @click="logout">ログアウト</button></li>
      </ul>
    </nav>

    <div>
      <textarea v-model="post"></textarea>
      <button @click="submitPost">シェアする</button>
    </div>
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
      if (!this.post) return

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