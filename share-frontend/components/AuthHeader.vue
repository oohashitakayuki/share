<template>
  <header class="auth-header">
    <img src="logo.png" class="auth-header__logo" />

    <nav class="auth-header__nav">
      <NuxtLink to="/register" class="auth-header__link">新規登録</NuxtLink>
      <NuxtLink to="/login" class="auth-header__link">ログイン</NuxtLink>
    </nav>
  </header>
</template>

<script>
export default {}
</script>

<style scoped>
.auth-header {
  width: 100%;
  padding: 15px 35px 0 15px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: absolute;
  top: 0;
}

.auth-header__logo {
  width: 10%;
}

.auth-header__nav {
  width: 130px;
  justify-content: space-between;
  display: flex;
}

.auth-header__link {
  font-size: 14px;
  color: #FFF;
  text-decoration: none;
}
</style>