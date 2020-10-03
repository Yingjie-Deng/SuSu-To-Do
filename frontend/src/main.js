import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import 'element-ui/lib/theme-chalk/index.css';
import './assets/css/globle.css'
// 引入axios
import axios from 'axios'
// 配置请求的根路径
axios.defaults.baseURL = 'http://localhost/todo/susu/';
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
} from 'element-ui';

Vue.prototype.$message = Message;
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

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
