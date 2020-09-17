import Vue from 'vue'
import VueRouter from 'vue-router'
import Test from '../components/test.vue'
import Home from '../components/Home'
import Ha from '../components/Ha.vue'
// 引入任务相关的组件
import Myday from '../components/task/Myday.vue'
import Import from '../components/task/Import.vue'
import Ppf from '../components/task/Ppf.vue'

Vue.use(VueRouter)

const routes = [
  // {
  //   path: '/',
  //   name: 'Home',
  //   component: Home
  // },
  // {
  //   path: '/about',
  //   name: 'About',
  //   // route level code-splitting
  //   // this generates a separate chunk (about.[hash].js) for this route
  //   // which is lazy-loaded when the route is visited.
  //   component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  // }
  { path: '/', name: 'root', component: Ha },
  { path: '/todo', name: 'Test', component: Test },
  {
    path: '/todo/home', component: Home, redirect: '/todo/myday',
    children: [
      { path: '/todo/myday', component: Myday },
      { path: '/todo/import', component: Import },
      { path: '/todo/ppf', component: Ppf },
    ]
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
