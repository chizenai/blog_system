<template>
  <div class="category-list">
    <h2>分类列表</h2>
    <div v-if="loading" class="loading">加载中...</div>
    <div v-else>
      <ul>
        <li v-for="category in categories" :key="category.id">
          <router-link :to="{ name: 'category', params: { id: category.id }}">
            {{ category.name }}
          </router-link>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  name: 'CategoryList',
  data() {
    return {
      categories: [],
      loading: false
    };
  },
  created() {
    this.fetchCategories();
  },
  methods: {
    async fetchCategories() {
      this.loading = true;
      try {
        const response = await api.getCategories();
        // 确保response.data存在且包含records数组
        if (response.data && response.data.records) {
          this.categories = response.data.records;
        } else {
          console.error('获取分类失败: 返回数据格式不正确');
          this.categories = [];
        }
      } catch (error) {
        console.error('获取分类失败:', error);
        alert('获取分类失败');
        this.categories = [];
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
.category-list {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  border-bottom: 1px solid #eee;
  padding: 10px 0;
}

li:last-child {
  border-bottom: none;
}

a {
  text-decoration: none;
  color: #2196F3;
  font-weight: bold;
}

a:hover {
  text-decoration: underline;
}

.loading {
  text-align: center;
  padding: 20px;
  font-style: italic;
  color: #666;
}
</style>
