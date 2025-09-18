<template>
  <div class="post-list">
    <h2>文章列表</h2>
    <div v-if="loading" class="loading">加载中...</div>
    <div v-else>
      <div v-if="posts.length === 0" class="no-posts">暂无文章</div>
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
  </div>
</template>

<script>
import api from '../services/api';

export default {
  name: 'PostList',
  data() {
    return {
      posts: [],
      loading: false
    };
  },
  created() {
    this.fetchPosts();
  },
  methods: {
    async fetchPosts() {
      this.loading = true;
      try {
        const response = await api.getPosts();
        // 确保response.data存在且包含records数组
        if (response.data && response.data.records) {
          this.posts = response.data.records;
        } else {
          console.error('获取文章失败: 返回数据格式不正确');
          this.posts = [];
        }
      } catch (error) {
        console.error('获取文章失败:', error);
        alert('获取文章失败');
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
.post-list {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
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

.loading, .no-posts {
  padding: 20px;
  font-style: italic;
  color: #666;
}
</style>
