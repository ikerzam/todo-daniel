import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '@/views/LoginView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/RegisterView.vue')
    },
    {
      path: '/todos',
      name: 'todos',
      component: () => import('../views/TodosView.vue')
    },
    {
      path: '/todos/create',
      name: 'todo_create',
      component: () => import('../views/TodosCreateView.vue')
    }
  ]
})

export default router
