<template>
  <el-container style="height: 100vh; border: 1px solid #eee">
    <el-aside width="280px" style="background-color: white">
      <div class="person-info-container">
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
              :src="personInfo.head_sculpture"
              @error="errorHandler"
            >
              <img
                src="https://cube.elemecdn.com/e/fd/0fc7d20532fdaf769a25683617711png.png"
              />
            </el-avatar>
            <div class="personInfo">
              <h5 class="username">{{ personInfo.name }}</h5>
              <h6 class="loginmark">{{ personInfo.login_name }}</h6>
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
      </div>

      <!-- 菜单栏 -->
      <el-menu
        :default-active="activeMenu"
        class="el-menu-vertical-demo"
        background-color="#fbfcfe"
        router
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
        <el-menu-item index="/todo/all">
          <i class="el-icon-menu" style="color: #c8605c"></i>
          <span slot="title">全部</span>
        </el-menu-item>
        <el-menu-item index="/todo/completed">
          <i class="el-icon-circle-check" style="color: #c8605c"></i>
          <span slot="title">已完成</span>
        </el-menu-item>
        <el-menu-item index="/todo/task">
          <i class="el-icon-s-home" style="color: rgb(92, 112, 190)"></i>
          <span slot="title">任务</span>
        </el-menu-item>
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
        <el-menu-item index="/todo/all">
          <i class="el-icon-menu" style="color: #c8605c"></i>
          <span slot="title">全部</span>
        </el-menu-item>
        <el-menu-item index="/todo/completed">
          <i class="el-icon-circle-check" style="color: #c8605c"></i>
          <span slot="title">已完成</span>
        </el-menu-item>
        <el-menu-item index="/todo/task">
          <i class="el-icon-s-home" style="color: rgb(92, 112, 190)"></i>
          <span slot="title">任务</span>
        </el-menu-item>
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
        <el-menu-item index="/todo/all">
          <i class="el-icon-menu" style="color: #c8605c"></i>
          <span slot="title">全部</span>
        </el-menu-item>
        <el-menu-item index="/todo/completed">
          <i class="el-icon-circle-check" style="color: #c8605c"></i>
          <span slot="title">已完成</span>
        </el-menu-item>
        <el-menu-item index="/todo/task">
          <i class="el-icon-s-home" style="color: rgb(92, 112, 190)"></i>
          <span slot="title">任务</span>
        </el-menu-item>
        <el-menu-item index="/todo/completed">
          <i class="el-icon-circle-check" style="color: #c8605c"></i>
          <span slot="title">已完成</span>
        </el-menu-item>
        <el-menu-item index="/todo/task">
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
      personInfo: {
        name: '未登录',
        login_name: '登录后显示',
      },
    };
  },
  created() {
    this.loadInfo();
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
    // 加载用户信息和清单信息
    async loadInfo() {
      const { data: res } = await this.$http.get('home/load');
      // console.log(res);
      if (res.meta.status !== 200) return;
      this.personInfo = res.data.pInfo;
      window.localStorage.setItem('token', res.data.token);
      console.log(res);
    },
  },
  computed: {
    activeMenu() {
      const route = this.$route;
      const path = route.path;
      return path;
    },
  },
};
</script>

<style lang="less" scoped>
.el-aside {
  display: flex;
  flex-direction: column;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
  &::-webkit-scrollbar {
    width: 0;
  }
  -ms-overflow-style: none;
  overflow: -moz-scrollbars-none;
}
.person-info-container {
  flex-shrink: 0;
}
.el-menu {
  width: 100%;
  height: 100%;
  overflow: auto;
  -ms-overflow-style: none;
  overflow: -moz-scrollbars-none;
  &::-webkit-scrollbar {
    width: 0;
  }
}
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
.el-main {
  padding: 0px;
  &::-webkit-scrollbar {
    width: 0;
  }
  -ms-overflow-style: none;
  overflow: -moz-scrollbars-none;
}
</style>