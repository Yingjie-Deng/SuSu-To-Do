import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    taskList: null,
    defaultList: {lid: 'all_001', listName: '任务'},
  },
  mutations: {
  },
  actions: {
  },
  modules: {
  }
})
