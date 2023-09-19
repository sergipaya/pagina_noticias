import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ArticleFormView from '../views/ArticleFormView.vue'
import CommentFormView from '../views/CommentFormView.vue'
import UserPanelView from  '../views/UserPanelView.vue'
import NewsView from  '../views/NewsView.vue'
import ArticleView from  '../views/ArticleView.vue'
import LoginView from  '../views/LoginView.vue'
import RegisterView from  '../views/RegisterView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/news/:categoryName/add-article',
      name: 'add-article',
      props: true,
      component: ArticleFormView
    },
    {
      path: '/news/:categoryName/edit-article/:id',
      name: 'edit-article',
      props: true,
      component: ArticleFormView
    },
    {
      path: '/news/:categoryName/:articleId/add-comment',
      name: 'add-comment',
      props: true,
      component: CommentFormView
    },
    {
      path: '/news/:categoryName/:articleId/edit-comment/:id',
      name: 'edit-comment',
      props: true,
      component: CommentFormView
    },
    {
      path: '/user-panel',
      name: 'user-panel',
      component: UserPanelView
    },
    {
      path: '/news/:category',
      name: 'news',
      props: true,
      component: NewsView
    },
    {
      path: '/news/:category/:id',
      name: 'article',
      props: true,
      component: ArticleView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },
  ]
})

export default router