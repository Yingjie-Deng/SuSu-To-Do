import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import 'element-ui/lib/theme-chalk/index.css';
import './assets/css/globle.css'

// 引入Item组件
import Item from '@/components/suItem/index.js'
// 引入Input组件
import SuInput from '@/components/suInput/index.js'
// 引入 Button 组件
import SuButton from '@/components/SuButton.vue'
// 引入 Detail 组件
import SuDetail from '@/components/SuDetail.vue'
// 引入axios
import axios from 'axios'
// 配置请求的根路径
axios.defaults.baseURL = 'http://localhost/todo/index.php/susu/';
// 配置自动携带authorization
axios.interceptors.request.use(config => {
  config.headers.Authorization = window.localStorage.getItem('token');
  return config;
})

Vue.prototype.$http = axios;
import {
  Button,
  Select,
  Container,
  Aside,
  Main,
  Submenu,
  Table,
  TableColumn,
  Dropdown,
  DropdownMenu,
  Row,
  Col,
  Avatar,
  Menu,
  MenuItem,
  Card,
  Form,
  FormItem,
  Input,
  Message,
  Radio,
  Tooltip,
  DatePicker,
  Divider,
  Popover,
  Dialog,
  MessageBox,
  Pagination,
  Option,
  Upload,

} from 'element-ui';

Vue.prototype.$message = Message;
Vue.prototype.$Msg = MessageBox;
Vue.config.productionTip = false
Vue.use(Button)
Vue.use(Select)
Vue.use(Container)
Vue.use(Aside)
Vue.use(Main)
Vue.use(Submenu)
Vue.use(Table)
Vue.use(TableColumn)
Vue.use(Dropdown)
Vue.use(DropdownMenu)
Vue.use(Row)
Vue.use(Col)
Vue.use(Avatar)
Vue.use(Menu)
Vue.use(MenuItem)
Vue.use(Card)
Vue.use(Input)
Vue.use(FormItem)
Vue.use(Form)
Vue.use(Radio)
Vue.use(Item)
Vue.use(SuInput)
Vue.use(Tooltip)
Vue.use(DatePicker)
Vue.use(Divider)
Vue.use(Popover)
Vue.use(Dialog)
Vue.use(Pagination)
Vue.use(Option)
Vue.use(Upload)

Vue.component('SuButton', SuButton);
Vue.component('SuDetail', SuDetail);

// 配置响应拦截器
axios.interceptors.response.use(response => {
  const { data: res } = response;
  // 状态码为 2xx 的响应，更新 token
  const status = Number.parseInt(res.meta.status / 100);
  if (status === 2) {
    window.localStorage.setItem('token', res.data.token);
  }
  // const currRoutFull = router.currentRoute.fullPath;
  // console.log(currRoutFull);
  if (res.meta.status === 401 && router.currentRoute.fullPath !== '/todo/login') {
    Message({
      message: '登录失效',
      type: 'warning'
    });
    localStorage.removeItem('token');
    // sessionStorage.setItem('current', router.currentRoute.fullPath);
    router.push('/todo/login');
  }
  return response;
})

// 过滤器
Vue.filter('current', function () {
  const dt = new Date();
  const week = ['日', '一', '二', '三', '四', '五', '六'];
  const m = (dt.getMonth() + 1 + '').padStart(2, '0');
  const d = dt.getDate();
  const w = dt.getDay();
  return `${m}月${d}日，星期${week[w]}`;
})
// 星期几
Vue.filter('week', function () {
  const dt = new Date();
  const week = ['日', '一', '二', '三', '四', '五', '六'];
  const w = dt.getDay();
  if (arguments[1] === 11) {  // 下周一
    return '周一';
  }
  const index = (w + arguments[1]) % 7;
  return `周${week[index]}`;
})
new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
