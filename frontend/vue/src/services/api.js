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
    return api.get('/posts', { params }).then(response => {
      return response.data;
    });
  },

  getPost(id) {
    return api.get(`/posts?id=${id}`).then(response => {
      return response.data;
    });
  },

  createPost(post) {
    return api.post('/posts', post).then(response => {
      return response.data;
    });
  },

  updatePost(post) {
    return api.put(`/posts`, post).then(response => {
      return response.data;
    });
  },

  deletePost(id) {
    return api.delete(`/posts`, { data: { id: id } }).then(response => {
      return response.data;
    });
  },

  // 分类相关 API
  getCategories() {
    return api.get('/categories').then(response => {
      return response.data;
    });
  },

  getCategory(id) {
    return api.get(`/categories?id=${id}`).then(response => {
      return response.data;
    });
  },

  createCategory(category) {
    return api.post('/categories', category).then(response => {
      return response.data;
    });
  },

  updateCategory(category) {
    return api.put(`/categories`, category).then(response => {
      return response.data;
    });
  },

  deleteCategory(id) {
    return api.delete(`/categories`, { data: { id: id } }).then(response => {
      return response.data;
    });
  }
};