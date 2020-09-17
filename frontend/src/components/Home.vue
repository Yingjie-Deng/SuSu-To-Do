<template>
  <el-container style="height: 100vh; border: 1px solid #eee">
    <el-aside width="300px" style="background-color: white">
      <!-- 标题栏 -->
      <el-row>
        <el-col :span="24">
          <div class="grid-content bg-purple-dark">SuSu To-Do</div>
        </el-col>
      </el-row>
      <!--头像和用户信息栏 -->
      <el-row class="avatar">
        <el-col :span="20" class="avatarInfo">
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
        <el-col :span="4" class="search">
          <i class="el-icon-search"></i>
        </el-col>
      </el-row>
      <!-- 菜单栏 -->
      <el-menu default-active="/todo/myday" class="el-menu-vertical-demo" router="true">
        <el-menu-item index="/todo/myday">
          <i class="el-icon-sunny" style="color: #586570"></i>
          <span slot="title">我的一天</span>
        </el-menu-item>
        <el-menu-item index="/todo/import">
          <i class="el-icon-star-off" style="color: #b04365"></i>
          <span slot="title">重要</span>
        </el-menu-item>
        <el-menu-item index="/todo/ppf">
          <i class="el-icon-finished" style="color: #418669"></i>
          <span slot="title">往昔-当下-谜</span>
        </el-menu-item>
        <el-menu-item index="4">
          <i class="el-icon-menu" style="color: #c8605c"></i>
          <span slot="title">全部</span>
        </el-menu-item>
        <el-menu-item index="5">
          <i class="el-icon-circle-check" style="color: #c8605c"></i>
          <span slot="title">已完成</span>
        </el-menu-item>
        <el-menu-item index="6">
          <i class="el-icon-s-home" style="color: rgb(92, 112, 190)"></i>
          <span slot="title">任务</span>
        </el-menu-item>
      </el-menu>
    </el-aside>
    <el-main style="background-color: rgb(231, 236, 240)">
      <router-view />
    </el-main>
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
.avatarInfo {
  &:hover {
    background: rgb(250, 251, 252);
  }
}
.search {
  display: flex;
  justify-content: center;
  align-content: center;
  height: 39px;
  .el-icon-search {
    font-size: 16px;
  }
}
</style>