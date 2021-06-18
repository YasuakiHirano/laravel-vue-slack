import * as VueRouter from 'vue-router';

const routes = [
  {
    path: '/',
    name: 'Login',
    component: require('../components/pages/Login.vue').default
  },
  {
    path: '/chat',
    name: 'Chat',
    component: require('../components/pages/Chat.vue').default
  },
]

const router = VueRouter.createRouter({
  history: VueRouter.createWebHashHistory(),
  routes
})

export default router
