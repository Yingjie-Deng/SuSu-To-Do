<template>
  <div class="task-detail-container">
    <div class="task-main">
      <div class="header">
        <h1 class="title">
          <i class="el-icon-star-off" style="color: #b04365"></i>
          <span>重要</span>
        </h1>
      </div>
      <main class="main">
        <su-item
          :data="tasks.plan"
          title="content"
          other="listName"
          :activedId="activedId"
          @comp-toggle="firstComplete"
          @impt-toggle="firstImportToggle"
          @active="handleActive($event)"
        ></su-item>
        <su-button
          :count="count"
          v-if="count"
          @click.native="isfold = !isfold"
        ></su-button>
        <su-item
          :data="tasks.done"
          title="content"
          other="listName"
          :activedId="activedId"
          v-if="!isfold"
          @comp-toggle="secondComplete"
          @impt-toggle="secondImportToggle"
          @active="handleActive($event)"
        ></su-item>
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
      <div>{{ oneTask }}</div>
    </div>
  </div>
</template>

<script>
import Subase from '@/assets/base';
export default {
  data() {
    return {
      showDetail: false,
      tasks: { plan: [], done: [] },
      // taskList: this.$store.state.taskList,
      // 保存被激活的 item 的 tid
      activedId: '-1',
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
    async firstComplete(index) {
      Subase.complete.call(this, this.tasks.plan, index, this.loadTasks);
    },
    async secondComplete(index) {
      Subase.complete.call(this, this.tasks.done, index, this.loadTasks);
    },
    // 切换重要性
    async firstImportToggle(index) {
      Subase.importToggle.call(this, this.tasks.plan, index, this.loadTasks);
    },
    async secondImportToggle(index) {
      Subase.importToggle.call(this, this.tasks.done, index, this.loadTasks);
    },
    handleActive(tid) {
      if (tid !== this.activedId) {
        this.showDetail = true;
        this.activedId = tid;
        // 加载被激活任务的详细信息
        this.oneTask = tid;
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
      newItem.important = true;
      const { data: res } = await this.$http.post('tasks/addTask', newItem);
      if (res.meta.status !== 201) return this.$message.error('添加任务失败！');
      this.loadTasks();
    },
    // 获取数据
    async loadTasks() {
      const { data: res } = await this.$http.get('tasks/getImpt');
      // console.log('enter', res);
      if (res.meta.status !== 200) return this.$message.error('获取数据失败！');
      const mytasks = res.data.tasks,
        len = mytasks.length,
        tasks = { plan: [], done: [] };
      for (let i = 0; i < len; i++) {
        if (mytasks[i].end_time === '0000-00-00 00:00:00') {
          mytasks[i].complete = false;
        } else {
          mytasks[i].complete = true;
        }

        if (mytasks[i].import === '0') {
          mytasks[i].import = false;
        } else {
          mytasks[i].import = true;
        }

        if (mytasks[i].complete) {
          tasks.done.push(mytasks[i]);
        } else {
          tasks.plan.push(mytasks[i]);
        }
      }
      this.tasks = tasks;
      // window.localStorage.setItem('token', res.data.token);
      console.log(this.tasks);
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