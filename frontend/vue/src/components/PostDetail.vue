<template>
  <div class="post-detail">
    <div v-if="loading" class="loading">加载中...</div>
    <div v-else-if="post" class="post-content">
      <h1>{{ post.title }}</h1>
      <div class="post-meta">
        <span>发布时间: {{ formatDate(post.created_at) }}</span>
        <span v-if="post.updated_at">更新时间: {{ formatDate(post.updated_at) }}</span>
      </div>
      <div class="post-body">
        <p>{{ post.content }}</p>
      </div>
      <div class="post-actions">
        <router-link to="/" class="btn btn-primary">返回文章列表</router-link>
      </div>
    </div>
    <div v-else class="error">
      <h2>文章未找到</h2>
      <p>抱歉，找不到您要查看的文章。</p>
      <router-link to="/" class="btn">返回首页</router-link>
    </div>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  name: 'PostDetail',
  data() {
    return {
      post: null,
      loading: false
    };
  },
  created() {
    this.fetchPost();
  },
  watch: {
    // 当路由参数变化时重新获取数据
    '$route.params.id': {
      immediate: true,
      handler() {
        this.fetchPost();
      }
    }
  },
  methods: {
    async fetchPost() {
      this.loading = true;
      try {
        const response = await api.getPost(this.$route.params.id);
        this.post = response.data;
      } catch (error) {
        console.error('获取文章失败:', error);
        alert('获取文章失败');
      } finally {
        this.loading = false;
      }
    },
    formatDate(dateString) {
      if (!dateString) return '';
      return new Date(dateString).toLocaleString();
    }
  }
};
</script>

<style scoped>
.post-detail {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.post-content {
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.post-meta {
  font-size: 0.9em;
  color: #666;
  margin-bottom: 15px;
}

.post-body {
  margin-top: 20px;
  line-height: 1.6;
}

.post-actions {
  margin-top: 30px;
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

.btn-primary {
  background-color: #2196F3;
}

.error {
  text-align: center;
  padding: 20px;
}

.loading {
  text-align: center;
  padding: 20px;
  font-style: italic;
  color: #666;
}
</style>
