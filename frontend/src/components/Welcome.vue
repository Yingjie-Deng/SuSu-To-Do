<template>
  <div class="welcome">
    <p class="greet">greet.</p>
    <div class="config-box">
      <div class="config-1">
        <div class="imgs">
          <el-image :src="images.conf1" fit="contain"></el-image>
          <el-image :src="images.conf2" fit="contain"></el-image>
        </div>
        <div class="text">
          <p class="first">数据库连接配置参数</p>
          <p class="sec">位于图一的 config.php 文件中</p>
          <p class="third">具体参数如图二所示，可按实际情况修改</p>
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
            <el-button type="warning" @click="$router.push('/todo')"
              >未知的二级首页</el-button
            >
            <el-button type="danger" @click="$router.push('/todo/alter')"
              >危险按钮</el-button
            >
          </div>
          <div class="nonsense">
            <p class="first">就不写好看的页面了</p>
            <p class="sec">反正也不丑</p>
            <p class="third">天生骨相好，越看越好看。</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import conf1 from '@/assets/config.png';
import conf2 from '@/assets/conf2.png';
export default {
  data() {
    return {
      images: {
        conf1,
        conf2,
      },
    };
  },
};
</script>

<style lang="less" scoped>
.welcome {
  padding: 20px 40px;
  display: flex;
  flex-direction: column;
}
.greet {
  text-transform: capitalize;
  font-size: 40px;
  align-self: flex-start;
}
.config-box {
  margin: 40px;
}
.config-1 {
  display: flex;
}
.imgs {
  width: 300px;
  flex-shrink: 0;
  .el-image {
    display: block;
  }
  .el-image:last-child {
    margin-top: 20px;
  }
}
.text {
  margin-left: 40px;
  p {
    font-size: 24px;
    margin: 20px 0;
  }
  .route-btns {
    margin: 140px 0;
  }
}
</style>