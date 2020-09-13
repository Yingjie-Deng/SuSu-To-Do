import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import 'element-ui/lib/theme-chalk/index.css';
import './assets/css/globle.css'
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
} from 'element-ui';

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

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
