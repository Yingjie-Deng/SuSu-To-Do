import Vue from 'vue'
import VueRouter from 'vue-router'
import Test from '../components/test.vue'
import Home from '../components/user/Home'
import Root from '../components/Root.vue'
import NotFound from '../components/Notfound.vue'
// 引入任务相关的组件
import Myday from '../components/task/Myday.vue'
import Import from '../components/task/Import.vue'
import Ppf from '../components/task/Ppf.vue'
import Register from '../components/user/Register.vue'
import Login from '../components/user/Login.vue'
import All from '../components/task/All.vue'
import Complete from '../components/task/Complete.vue'
import Overdue from '../components/task/Overdue.vue'
import ListShow from '../components/task/ListShow.vue'
import Search from '../components/task/Search.vue'
import Alter from '../components/user/Alter.vue'
import Welcome from '../components/Welcome.vue'
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
  { path: '/', name: 'root', component: Root },
  { path: '/todo', name: 'Test', component: Test },
  {
    path: '/todo/home', component: Home, redirect: '/todo/myday',
    children: [
      { path: '/todo/myday', component: Myday },
      { path: '/todo/import', component: Import },
      { path: '/todo/ppf', component: Ppf },
      { path: '/todo/search', component: Search },
      { path: '/todo/all', component: All },
      { path: '/todo/completed', component: Complete },
      { path: '/todo/overdue', component: Overdue },
      { path: '/todo/lists/:lid', component: ListShow },
      { path: '/todo/alter', component: Alter },
    ]
  },
  { path: '/todo/register', component: Register },
  { path: '/todo/login', component: Login },
  { path: '/todo/welcome', component: Welcome },
  { path: '*', component: NotFound }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

// 挂载路由导航守卫
router.beforeEach((to, from, next) => {
  if (to.path === '/todo/login' || to.path === '/todo/register' || to.path === '/todo' || to.path === '/todo/welcome') return next();
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
  document.title = to.meta.title ? to.meta.title : 'SuSu To-Do'
  next();
})

export default router
