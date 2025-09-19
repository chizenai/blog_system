import axios from 'axios';

// 创建 axios 实例
const api = axios.create({
  baseURL: '/backend/api', // 使用当前域名的相对路径
  headers: {
    'Content-Type': 'application/json'
  },
  withCredentials: true // 启用跨域请求凭证
});

export default {
  // 文章相关 API
  getPosts(params = {}) {
    return api.get('/posts', { params });
  },

  getPost(id) {
    return api.get(`/posts?id=${id}`);
  },

  createPost(post) {
    return api.post('/posts', post);
  },

  updatePost(post) {
    return api.put(`/posts`, post);
  },

  deletePost(id) {
    return api.delete(`/posts`, { data: { id: id } });
  },

  // 分类相关 API
  getCategories() {
    return api.get('/categories');
  },

  getCategory(id) {
    return api.get(`/categories?id=${id}`);
  },

  createCategory(category) {
    return api.post('/categories', category);
  },

  updateCategory(category) {
    return api.put(`/categories`, category);
  },

  deleteCategory(id) {
    return api.delete(`/categories`, { data: { id: id } });
  }
};