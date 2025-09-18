<template>
  <div class="category-posts">
    <div v-if="loading" class="loading">加载中...</div>
    <div v-else-if="category">
      <h2>{{ category.name }} 下的文章</h2>
      <div v-if="posts.length === 0" class="no-posts">该分类下暂无文章</div>
      <div v-else class="posts">
        <div v-for="post in posts" :key="post.id" class="post-item">
          <h3>
            <router-link :to="{ name: 'post', params: { id: post.id }}">{{ post.title }}</router-link>
          </h3>
          <div class="post-meta">
            <span>发布时间: {{ formatDate(post.created_at) }}</span>
          </div>
          <p class="post-excerpt">{{ truncateText(post.content, 150) }}</p>
        </div>
      </div>
    </div>
    <div v-else class="error">
      <h2>分类未找到</h2>
      <p>抱歉，找不到您要查看的分类。</p>
      <router-link to="/" class="btn">返回首页</router-link>
    </div>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  name: 'CategoryPosts',
  data() {
    return {
      category: null,
      posts: [],
      loading: false
    };
  },
  created() {
    this.fetchCategory();
    this.fetchPosts();
  },
  watch: {
    // 当路由参数变化时重新获取数据
    '$route.params.id': {
      immediate: true,
      handler() {
        this.fetchCategory();
        this.fetchPosts();
      }
    }
  },
  methods: {
    async fetchCategory() {
      try {
        const response = await api.getCategory(this.$route.params.id);
        this.category = response.data;
      } catch (error) {
        console.error('获取分类失败:', error);
        this.category = null;
      }
    },
    async fetchPosts() {
      this.loading = true;
      try {
        const response = await api.getPosts({ category_id: this.$route.params.id });
        this.posts = response.data.records || [];
      } catch (error) {
        console.error('获取文章失败:', error);
        this.posts = [];
      } finally {
        this.loading = false;
      }
    },
    truncateText(text, length) {
      if (!text) return '';
      return text.length > length ? text.substring(0, length) + '...' : text;
    },
    formatDate(dateString) {
      if (!dateString) return '';
      return new Date(dateString).toLocaleString();
    }
  }
};
</script>

<style scoped>
.category-posts {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.posts {
  margin-top: 20px;
}

.post-item {
  border: 1px solid #eee;
  padding: 15px;
  margin-bottom: 20px;
  border-radius: 5px;
}

.post-meta {
  font-size: 0.9em;
  color: #666;
  margin-bottom: 10px;
}

.post-excerpt {
  text-align: left;
}

.btn {
  display: inline-block;
  padding: 8px 16px;
  background-color: #4CAF50;
  color: white;
  text-decoration: none;
  border-radius: 4px;
  border: none;
  cursor: pointer;
}

.error {
  text-align: center;
  padding: 20px;
}

.loading, .no-posts {
  text-align: center;
  padding: 20px;
  font-style: italic;
  color: #666;
}
</style>
