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
        <el-col :span="20" class="avatarInfo" @click.native="clickPersonInfo">
          <el-avatar
            :size="35"
            src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"
            @error="errorHandler"
          >
            <img
              src="https://cube.elemecdn.com/e/fd/0fc7d20532fdaf769a25683617711png.png"
            />
          </el-avatar>
          <div class="personInfo">
            <h5 class="username">邓英杰</h5>
            <h6 class="loginmark">LXTHLD@Outlook.com</h6>
          </div>
        </el-col>
        <el-col :span="4" class="search" @click.native="clickSearch">
          <i class="el-icon-search"></i>
        </el-col>
      </el-row>
      <!-- 用户信息的Card -->
      <el-card class="showPerson-card" v-if="showPerson">
        <ul>
          <li>
            <i class="el-icon-user"></i>
            <p>管理账户</p>
          </li>
          <li @click="clickSetting">
            <i class="el-icon-setting"></i>
            <p>设置</p>
          </li>
        </ul>
      </el-card>
      <!-- 菜单栏 -->
      <el-menu
        default-active="/todo/myday"
        class="el-menu-vertical-demo"
        background-color="#fbfcfe"
        :router="true"
      >
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
  data() {
    return {
      showPerson: false,
    };
  },
  methods: {
    errorHandler() {
      return true;
    },
    clickPersonInfo() {
      this.showPerson = !this.showPerson;
    },
    clickSearch() {
      this.$router.push('search');
    },
    clickSetting() {
      this.$router.push({ path: 'setting' });
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
  cursor: pointer;
  &:hover {
    background: rgb(250, 251, 252);
  }
}
.search {
  height: 39px;
  text-align: center;
  cursor: pointer;
  &:hover {
    background-color: #fafbfc;
  }
  .el-icon-search {
    padding: 0;
    font-size: 16px;
    line-height: 39px;
  }
}
.showPerson-card {
  position: absolute;
  left: 15px;
  top: 90px;
  width: 260px;
  z-index: 10;
  box-shadow: 4px 10px 14px #bbb, 0px 0px 8px -4px #aaa !important;
  /deep/ .el-card__body {
    padding: 0;
  }
  ul {
    list-style-type: none;
    li {
      padding: 15px;
      cursor: pointer;
      i {
        font-size: 16px;
      }
      p {
        margin-left: 12px;
        display: inline-block;
      }
    }
    li:first-child {
      border-bottom: 1px solid #ddd;
    }
    li:hover {
      background: #f5f6f7;
    }
  }
}
.el-menu-item {
  &:hover {
    background: #f4f1f1 !important;
  }
}
</style>