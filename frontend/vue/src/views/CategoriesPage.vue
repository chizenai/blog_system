<template>
  <div class="categories-page">
    <header class="header">
      <h1>博客分类</h1>
      <nav>
        <router-link to="/" class="nav-link">返回首页</router-link>
      </nav>
    </header>

    <main class="main-content">
      <CategoryList />
    </main>

    <footer class="footer">
      <p>&copy; {{ new Date().getFullYear() }} 我的博客 | 使用 Vue.js 构建</p>
    </footer>
  </div>
</template>

<script>
import CategoryList from '../components/categorylist.vue';

export default {
  name: 'CategoriesPage',
  components: {
    CategoryList
  }
}
</script>

<style scoped>
.categories-page {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.header {
  background-color: #2196F3;
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
