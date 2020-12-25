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
            <li @click="handleUserClick">
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
          <i class="el-icon-circle-check" style="color: #1e704d"></i>
          <span slot="title">已完成</span>
        </el-menu-item>
        <el-menu-item index="/todo/overdue">
          <i class="el-icon-circle-close" style="color: #f00"></i>
          <span>逾期未完成</span>
        </el-menu-item>
        <el-menu-item index="/todo/lists/all_001">
          <i class="el-icon-s-home" style="color: rgb(92, 112, 190)"></i>
          <span slot="title">任务</span>
        </el-menu-item>
      </el-menu>

      <div class="divider"><el-divider></el-divider></div>
      <!-- 任务清单列表 -->
      <el-menu
        :default-active="activeMenu"
        class="el-menu-vertical-demo"
        background-color="#fbfcfe"
        router
      >
        <el-menu-item
          :index="'/todo/lists/' + item.lid"
          v-for="(item, index) in this.$store.state.taskList"
          :key="item.lid"
          @contextmenu.native.prevent="handleManageList($event, index)"
        >
          <i class="el-icon-collection" style="color: #5c70be"></i>
          <span slot="title">{{ item.listName }}</span>
        </el-menu-item>
      </el-menu>
      <!-- 新建清单 -->
      <div style="margin: 15px">
        <el-input
          placeholder="新建清单"
          v-model="newListName"
          clearable
          @keyup.enter.native="handleAddList"
        >
          <template #append>
            <el-button type="primary" class="my-primary" @click="handleAddList"
              >添加</el-button
            >
          </template>
        </el-input>
      </div>

      <!-- 右键管理菜单 -->
      <div class="mask" :style="styleMask" @click="handleMask">
        <ul :style="styleManage" class="manage-box">
          <li class="manage-list" @click.stop="renameList">
            <i class="el-icon-edit"></i><span>重命名</span>
          </li>
          <li class="manage-list" @click.stop="deleteLit">
            <i class="el-icon-delete"></i><span>删除</span>
          </li>
        </ul>
      </div>
      <!-- 重命名的 dialog -->
      <el-dialog title="重命名清单" :visible.sync="isVisible" width="400px">
        <div class="rename-list">
          当前名：
          <el-input
            placeholder=""
            v-model="this.renameItem.listName"
            :disabled="true"
          >
          </el-input>
        </div>
        <div class="rename-list">
          重命名：
          <el-input placeholder="请输入新的清单名" v-model="newName">
          </el-input>
        </div>
        <div slot="footer" class="dialog-footer">
          <el-button
            @click="
              isVisible = false;
              newName = '';
            "
            >取 消</el-button
          >
          <el-button type="primary" @click="confirmRename">确 定</el-button>
        </div>
      </el-dialog>
      <!-- 修改用户信息的dialog -->
      <el-dialog
        title="管理账户"
        class="manager-dialog"
        :visible.sync="showUserDialog"
        width="328px"
        :show-close="false"
      >
        <!-- 展示一下用户信息 -->
        <span class="dialog-user-info">
          <el-avatar
            :size="40"
            :src="personInfo.head_sculpture"
            @error="errorHandler"
          >
            <img
              src="https://cube.elemecdn.com/e/fd/0fc7d20532fdaf769a25683617711png.png"
            />
          </el-avatar>
          <!-- 信息列 -->
          <div class="dialog-person-info">
            <h5 class="username">{{ personInfo.name }}</h5>
            <h6 class="loginmark">{{ personInfo.login_name }}</h6>
          </div>
          <!-- 退出登录按钮 -->
          <div class="cancelBtn">
            <el-button type="danger" @click="isCancelHandler">退出</el-button>
          </div>
        </span>
        <!-- 修改用户信息的按钮 -->
        <span class="alert-userinfo" @click="alterBtnHandler">
          <span class="icon"><i class="el-icon-plus"></i></span>
          <span class="alert-btn">修改信息</span>
        </span>
        <template #footer>
          <span class="user-dialog-footer">
            <el-button @click="showUserDialog = false">关 闭</el-button>
          </span>
        </template>
      </el-dialog>
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
      taskList: null,
      newListName: '',
      styleManage: {
        display: 'none',
        left: '',
        top: '',
      },
      styleMask: {
        display: 'none',
      },
      // 控制 dialog 的展示
      isVisible: false,
      // list 清单的索引
      listIndex: 0,
      // list 列表
      // listCopy: this.$store.state.taskList,
      // 待改名的清单
      renameItem: { tid: '', listName: '' },
      // list 的新名字
      newName: '',
      // 控制 user-dialog 的显示
      showUserDialog: false,
    };
  },
  created() {
    this.loadInfo();
    // 获取任务清单
    this.getList();
  },
  watch: {
    // listCopy(val) {
    //   this.renameItem = val[this.listIndex];
    // },
  },
  computed: {
    activeMenu() {
      const route = this.$route;
      const path = route.path;
      return path;
    },
    listCopy() {
      return this.$store.state.taskList;
    },
  },
  methods: {
    errorHandler() {
      return true;
    },
    clickPersonInfo() {
      this.showPerson = !this.showPerson;
    },
    // 处理“管理账户”的点击事件
    handleUserClick() {
      this.showUserDialog = true;
      this.showPerson = false;
    },
    clickSearch() {
      this.$router.push('/todo/search');
    },
    clickSetting() {
      this.$router.push('/todo/setting');
    },
    // 询问是否确认退出
    isCancelHandler() {
      this.$Msg
        .confirm('确认退出登录？', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning',
        })
        .then(() => {
          window.localStorage.removeItem('token');
          this.$message({
            type: 'success',
            message: '退出成功!',
          });
          this.$router.push('/todo/login');
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: '已取消',
          });
        });
    },
    // 修改用户信息的事件处理程序
    alterBtnHandler() {
      this.showUserDialog = false;
      this.$router.push('/todo/alter');
    },
    // 加载用户信息和清单信息
    async loadInfo() {
      const { data: res } = await this.$http.get('home/load');
      // console.log(res);
      if (res.meta.status !== 200) return;
      this.personInfo = res.data.pInfo;
      // window.localStorage.setItem('token', res.data.token);
      console.log(res);
    },
    /**
     * 获取任务清单
     */
    async getList() {
      const { data: res } = await this.$http.get('tasks/loadList');
      if (res.meta.status !== 200)
        return this.$message({ message: '获取任务清单失败！', type: 'error' });
      this.$store.state.taskList = res.data.list;
      this.taskList = this.$store.state.taskList;
    },
    // 添加任务清单
    async handleAddList() {
      if (!this.newListName) {
        return this.$message.warning('清单名不能为空！');
      }
      let newList = { name: this.newListName };
      let res = null;
      try {
        const { data: res1 } = await this.$http.post('list/addList', newList);
        res = res1;
      } catch (error) {
        this.$message.error('添加清单错误！');
        return;
      }
      if (res.meta.status !== 201) {
        return this.$message.error('添加清单失败！');
      }
      this.getList();
      this.newListName = '';
    },
    // 右键管理
    handleManageList(e, index) {
      const x = e.clientX;
      const y = e.clientY;
      this.listIndex = index;
      // this.listCopy = this.$store.state.taskList;
      this.renameItem = this.listCopy[index];
      this.styleManage.display = 'block';
      this.styleManage.left = x + 10 + 'px';
      this.styleManage.top = y + 10 + 'px';
      this.styleMask.display = 'block';
    },
    // mask
    handleMask() {
      this.styleMask.display = 'none';
      this.styleManage.display = 'none';
      console.log('hf: ', this.styleMask, this.styleManage);
    },
    renameList() {
      this.styleMask.display = 'none';
      this.styleManage.display = 'none';
      this.isVisible = true;
    },
    deleteLit() {
      this.styleMask.display = 'none';
      this.styleManage.display = 'none';
      this.$Msg
        .confirm('确认删除清单？', '删除清单', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning',
        })
        .then(async () => {
          let res = null;
          try {
            const { data: res1 } = await this.$http.post(
              'list/remove',
              this.renameItem
            );
            res = res1;
          } catch (error) {
            return this.$message.error('删除错误！');
          }
          if (res.meta.status !== 204) {
            return this.$message.error('删除失败！');
          }
          this.getList();
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: '已取消删除',
          });
        });
    },
    // 确定重命名
    async confirmRename() {
      const newListInfo = this.renameItem;
      newListInfo.listName = this.newName;
      let res = null;
      try {
        const { data: res1 } = await this.$http.post(
          'list/rename',
          newListInfo
        );
        res = res1;
      } catch (error) {
        this.$message.error('重命名出错！');
        return;
      }
      if (res.meta.status !== 200) {
        return this.$message.error('重命名失败！');
      }
      this.getList();
      this.newName = '';
      this.isVisible = false;
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
  // height: 100%;
  border: none;
  overflow: auto;
  -ms-overflow-style: none;
  overflow: -moz-scrollbars-none;
  &::-webkit-scrollbar {
    width: 0;
  }
}
.divider {
  margin: 0;
  padding: 10px 20px;
  // width: 99%;
  background-color: #fbfcfe;
}
.el-divider {
  margin: 0px;
  padding: 0;
  // width: 278px;
  box-sizing: border-box;
  background-color: #dddddd;
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
.mask {
  width: 100vw;
  height: 100vh;
  // opacity: 0;
  background: #ffcdcd00;
  position: absolute;
  z-index: 1;
}
.manage-box {
  position: absolute;
  width: 200px;
  box-shadow: 4px 10px 14px #bbb, 0px 0px 8px -4px #aaa;
  // border: 1px solid #000;
  border-radius: 8px;
  overflow: hidden;
  .manage-list {
    list-style-type: none;
    cursor: pointer;
    padding: 15px;
    background-color: #fff;
    span {
      padding-left: 10px;
    }
    &:hover {
      background-color: #f5f6f7;
    }
  }
  .manage-list:last-child {
    color: #f00;
    border-top: 1px solid #ededed;
  }
}
.rename-list:first-child {
  margin-bottom: 15px;
}
// .el-input /deep/.el-button {
//   background: #fff;
// }
// .el-input /deep/.el-input-group__append .el-button.my-primary {
//   color: #fff;
//   background-color: #409eff;
//   border-color: #409eff;
// }
/deep/.el-dialog__header {
  text-align: center;
  padding: 16px 16px 10px;
  .el-dialog__title {
    font-size: 16px;
    font-weight: 800;
  }
}
.manager-dialog /deep/.el-dialog__body {
  padding: 10px 0 0;
}
.dialog-user-info {
  display: flex;
  padding: 16px;
  justify-content: space-between;
  &:hover {
    background-color: #fafbfc;
  }
  .dialog-person-info {
    padding-right: 30px;
    .username {
      color: #000;
    }
  }
}
.alert-userinfo {
  display: flex;
  height: 40px;
  padding: 16px;
  align-items: center;
  box-sizing: content-box;
  &:hover {
    background-color: #fafbfc;
  }
  .icon {
    padding: 0 20px 0 10px;
    .el-icon-plus {
      font-size: 24px;
      font-weight: 800;
      color: #9d9d9d;
    }
  }
  .alert-btn {
    font-size: 16px;
    // font-weight: 300;
    color: #000;
  }
}
</style>