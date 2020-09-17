<template>
  <div>
    <h1>根路径</h1>
    <el-button type="primary" plain @click="toTodoHandler">去todo</el-button>
    <el-button type="success" plain @click="toHomeHandler">去home</el-button>
  </div>
</template>

<script>
export default {
  methods: {
    toTodoHandler() {
      this.$router.push('todo');
    },
    toHomeHandler() {
      this.$router.push('todo/home');
    }
  },
};
</script>

<style>
</style>