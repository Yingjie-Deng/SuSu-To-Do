<template>
  <el-container style="height: 100vh; border: 1px solid #eee">
    <el-aside width="300px" style="background-color: white">
      <el-row>
        <el-col :span="24">
          <div class="grid-content bg-purple-dark">SuSu To-Do</div>
        </el-col>
      </el-row>
      <el-row class="avatar">
        <el-col :span="20">
          <el-avatar
            :size="35"
            src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"
            @error="errorHandler"
          >
            <img src="https://cube.elemecdn.com/e/fd/0fc7d20532fdaf769a25683617711png.png" />
          </el-avatar>
          <div class="personInfo">
            <h5 class="username">邓英杰</h5>
            <h6 class="loginmark">LXTHLD@Outlook.com</h6>
          </div>
        </el-col>
        <el-col :span="4"></el-col>
      </el-row>
    </el-aside>
    <el-main style="background-color: rgb(231, 236, 240)">adfsg</el-main>
  </el-container>
</template>

<script>
export default {
  methods: {
    errorHandler() {
      return true;
    },
  },
};
</script>

<style lang="less" scoped>
.el-row {
  margin: 10px;
}
.grid-content {
  font-size: 14px;
  color: #737373;
}
.personInfo {
  margin-left: 8px;
  display: inline-block;
}
.username,
.loginmark {
  font-weight: 400;
}
.username {
  font-size: 16px;
}
.loginmark {
  font-size: 12px;
}
</style>