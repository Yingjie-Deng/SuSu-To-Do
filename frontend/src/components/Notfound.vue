<template>
  <div class="not-found">
    <div class="not-found-box">
      <h1 class="title">假装自己是个 404</h1>
      <div class="introduce">
        <div class="truly">
          <p class="truly-text">404</p>
          <p class="truly-intro">真实的我</p>
        </div>
        <div class="falsly">
          <p class="falsly-text">200</p>
          <p class="falsly-intro">我和其他组件没什么不同</p>
        </div>
        <div class="pretend">
          <p class="pretend-text">200-404</p>
          <p class="pretend-intro">你看见的我</p>
        </div>
      </div>
    </div>
    <div class="route-btns">
      <el-button type="primary" @click="$router.push('/todo/home')"
        >去 Home</el-button
      >
      <el-button type="success" @click="$router.push('/todo/login')"
        >去登录</el-button
      >
      <el-button type="info" @click="$router.push('/')"
        >未知的首页</el-button
      >
      <el-button type="warning" @click="$router.push('/todo')">未知的二级首页</el-button>
      <el-button type="danger" @click="$router.push('/todo/alter')">危险按钮</el-button>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style lang="less" scoped>
.not-found {
  display: flex;
  flex-direction: column;
  height: 100%;
  justify-content: center;
  align-items: center;
}
.route-btns {
  margin-top: 30px;
}
</style>