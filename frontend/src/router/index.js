import Vue from 'vue'
import VueRouter from 'vue-router'
import Test from '../components/test.vue'
import Home from '../components/Home'
import Ha from '../components/Ha.vue'
// 引入任务相关的组件
import Myday from '../components/task/Myday.vue'
import Import from '../components/task/Import.vue'
import Ppf from '../components/task/Ppf.vue'
import Register from '../components/Register.vue'
import Login from '../components/Login.vue'
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
      { path: '/todo/search', component: Ppf }
    ]
  },
  { path: '/todo/register', component: Register },
  { path: '/todo/login', component: Login },
]

const router = new VueRouter({
  mode: 'history',
  routes
})

// 挂载路由导航守卫
router.beforeEach((to, from, next) => {
  if (to.path === '/todo/login' || to.path === '/todo/register' || to.path === '/todo') return next();
  // 去其他页面，需要登录，获取token
  // 保存要去的页面，登录成功后回来。
  window.sessionStorage.setItem('current', to.path);
  const token = window.localStorage.getItem('token');
  if (!token) {
    Vue.prototype.$message({
      message: '未登录',
      type: 'warning'
    });
    return next('/todo/login');
  }
  next();
})

export default router
