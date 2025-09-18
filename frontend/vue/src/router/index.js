import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import PostDetail from '../components/PostDetail.vue'
import CategoryPosts from '../components/CategoryPosts.vue'
import CategoriesPage from '../views/CategoriesPage.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/post/:id',
    name: 'post',
    component: PostDetail,
    props: true
  },
  {
    path: '/category/:id',
    name: 'category',
    component: CategoryPosts,
    props: true
  },
  {
    path: '/categories',
    name: 'Categories',
    component: CategoriesPage
  }
]

const router = createRouter({
  history: createWebHistory('/php+vue/frontend/'),
  routes
})

export default router
