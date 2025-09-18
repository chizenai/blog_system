<template>
  <div class="home">
    <header class="header">
      <h1>我的博客</h1>
      <nav>
        <router-link to="/" class="nav-link">首页</router-link>
        <router-link to="/categories" class="nav-link">分类</router-link>
      </nav>
    </header>

    <main class="main-content">
      <PostList />
    </main>

    <footer class="footer">
      <p>&copy; {{ new Date().getFullYear() }} 我的博客 | 使用 Vue.js 构建</p>
    </footer>
  </div>
</template>

<script>
import PostList from '../components/PostList.vue';

export default {
  name: 'Home',
  components: {
    PostList
  }
}
</script>

<style scoped>
.home {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.header {
  background-color: #4CAF50;
  color: white;
  padding: 20px;
  text-align: center;
}

.header h1 {
  margin: 0;
  font-size: 2.5rem;
}

.nav-link {
  color: white;
  margin: 0 15px;
  text-decoration: none;
  font-weight: bold;
}

.nav-link:hover {
  text-decoration: underline;
}

.main-content {
  flex: 1;
  padding: 20px;
}

.footer {
  background-color: #333;
  color: white;
  text-align: center;
  padding: 15px;
  margin-top: auto;
}
</style>
