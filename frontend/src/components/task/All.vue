<template>
  <div class="task-detail-container">
    <div class="task-main">
      <div class="header">
        <h1 class="title">
          <i class="el-icon-menu" style="color: #c8605c"></i>
          <span>全部</span>
        </h1>
      </div>
      <main class="main">
        <div class="item-box" v-for="(tasksObj, name) in tasks" :key="name">
          <su-button
            :count="tasksObj.count"
            v-if="tasksObj.count"
            @click.native="tasksObj.isfold = !tasksObj.isfold"
          >
            <template>{{ name }}</template>
          </su-button>
          <su-item
            :data="tasksObj.tasks"
            title="content"
            other="deadline"
            :activedId="activedId"
            v-if="!tasksObj.isfold"
            @comp-toggle="complete(name, $event)"
            @impt-toggle="importToggle(name, $event)"
            @active="handleActive($event)"
          ></su-item>
        </div>
      </main>
      <su-input
        placeholder="添加任务"
        :list-prop="taskList"
        @select-lid="handleSelectLid"
        :default-list="defaultList"
        @keyup-enter="handleEnter"
      ></su-input>
    </div>

    <div class="su-detail" v-if="showDetail">
      <h1>title</h1>
      <div>{{ oneTask.content + ' -- 截止时间：' + oneTask.deadline }}</div>
    </div>
  </div>
</template>

<script>
import Subase from '@/assets/base';
export default {
  data() {
    return {
      showDetail: false,
      tasks: {},
      // 详情信息
      oneTask: null,
      // taskList: this.$store.state.taskList,
      // 保存被激活的 item 的 tid
      activedId: '-1',

      // count: this.tasks.done.length,
      // 控制折叠
      isfold: false,
    };
  },
  created() {
    // 加载任务记录
    this.loadTasks();
  },
  computed: {
    // 从 vuex 获取清单 list
    taskList() {
      return this.$store.state.taskList;
    },
    // 获取默认的清单
    defaultList() {
      return this.$store.state.defaultList;
    },
    // 记录完成任务数量
    count() {
      return this.tasks.done.length;
    },
  },
  methods: {
    // 任务完成
    async complete(name, index) {
      Subase.complete.call(this, this.tasks[name].tasks, index, this.loadTasks);
    },
    // async secondComplete(index) {
    //   Subase.complete.call(this, this.tasks.done, index, this.loadTasks);
    // },
    // 切换重要性
    async importToggle(name, index) {
      Subase.importToggle.call(this, this.tasks[name].tasks, index, this.loadTasks);
    },
    // async secondImportToggle(index) {
    //   Subase.importToggle.call(this, this.tasks.done, index, this.loadTasks);
    // },
    handleActive(tid) {
      if (tid !== this.activedId) {
        this.showDetail = true;
        this.activedId = tid;
        // 加载被激活任务的详细信息
        this.detail();
      } else {
        // 被激活的 item 与上一次相同，即关闭详细页
        this.showDetail = false;
        this.activedId = '-1';
      }

      console.log(tid);
    },
    handleSelectLid(lid) {
      this.lid = lid;
      console.log(this.lid);
    },
    // 添加记录事件处理函数
    async handleEnter(newItem) {
      const { data: res } = await this.$http.post('tasks/addTask', newItem);
      if (res.meta.status !== 201) return this.$message.error('添加任务失败！');
      this.loadTasks();
    },
    // 获取数据
    async loadTasks() {
      const { data: res } = await this.$http.get('tasks/getAll');
      console.log('enter', res);
      if (res.meta.status !== 200) return this.$message.error('获取数据失败！');

      this.tasks = res.data.tasks;
      // window.localStorage.setItem('token', res.data.token);
      console.log('tasks::', this.tasks);
    },
    // 获取详细信息
    async detail() {
      const {data: res} = await this.$http.get('tasks/detail?tid=' + this.activedId);
      if (res.meta.status !== 200) {
        return this.$message.error('获取详细信息错误！');
      }
      this.oneTask = res.data.detail;
    },
  },
};
</script>

<style lang="less" scoped>
.title {
  color: #586570;
  font-size: 30px;
  span {
    padding-left: 20px;
  }
}
.datetime {
  margin-left: 50px;
  color: #586570;
  font-size: 14px;
}
.task-main {
  display: flex;
  flex: 1;
  flex-direction: column;
  overflow: auto;
  height: 100%;
  position: relative;
  &::-webkit-scrollbar {
    width: 0;
  }
  -ms-overflow-style: none;
  overflow: -moz-scrollbars-none;
  // flex-basis: auto;
  // width: 100%;
}
.header {
  flex-shrink: 0;
}
main.main {
  flex: 1;
  margin-top: 30px;
  width: 100%;
  overflow: auto;
  -ms-overflow-style: none;
  overflow: -moz-scrollbars-none;
  &::-webkit-scrollbar {
    width: 0;
  }
}
.su-item {
  // flex: 1;
  // margin-top: 30px;
  width: 100%;
}
.task-main .su-input {
  width: 100%;
}
.su-detail {
  flex-shrink: 0;
  width: 360px;
  height: 100%; /**container 有1px的边框 因此不用 100vh */
  background: #f5f5f5;
}
</style>