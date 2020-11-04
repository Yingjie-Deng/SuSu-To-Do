import ItemComponent from './Item.vue'

const Item = {
  install: function (Vue) {
    Vue.component('SuItem', ItemComponent)
  }
}

export default Item