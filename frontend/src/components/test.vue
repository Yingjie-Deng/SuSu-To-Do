<template>
  <div class="container">
    <h1>title</h1>
    <div>body
      <el-button type="success" plain @click="toHomeHandler">去home</el-button>
      <el-button type="success" plain @click="toRegHandler">去注册</el-button>
    </div>
  </div>
</template>

<script>
export default {
methods: {
  toHomeHandler() {
    this.$router.push('/todo/home');
  },
  toRegHandler() {
    this.$router.push('/todo/register');
  }
}
}
</script>

<style lang="less" scoped>
.container {
  background: rgb(199, 197, 197);
  width: 1200px;
  margin: 0 auto;
  h1 {
    text-align: center;
  }
  div {
    border: 2px solid pink;
  }
}
</style>