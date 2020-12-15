<template>
  <div class="task-detail-container">
    <div class="task-main">
      <div class="header">
        <h1 class="title">
          <i class="el-icon-finished" style="color: #418669"></i>
          <span>昨天-今天-明天</span>
        </h1>
      </div>
      <!-- 任务主体 -->
      <main class="main">
        <!-- 往昔 -->
        <section class="yesterday">
          <div class="title">yday</div>
          <div class="item-box">
            <su-item
              :data="yesterdayTasks.plan"
              title="content"
              other="listName"
              :activedId="activedId"
              @comp-toggle="yFirstComplete"
              @impt-toggle="yFirstImportToggle"
              @active="handleActive($event)"
            ></su-item>
            <su-button
              :count="ycount"
              v-if="ycount"
              @click.native="yisfold = !yisfold"
            ></su-button>
            <su-item
              :data="yesterdayTasks.done"
              title="content"
              other="listName"
              :activedId="activedId"
              v-if="!yisfold"
              @comp-toggle="ySecondComplete"
              @impt-toggle="ySecondImportToggle"
              @active="handleActive($event)"
            ></su-item>
          </div>
        </section>
        <!-- 今天 -->
        <section class="today">
          <div class="title">today</div>
          <div class="item-box">
            <su-item
              :data="todayTasks.plan"
              title="content"
              other="listName"
              :activedId="activedId"
              @comp-toggle="tFirstComplete"
              @impt-toggle="tFirstImportToggle"
              @active="handleActive($event)"
            ></su-item>
            <su-button
              :count="tcount"
              v-if="tcount"
              @click.native="tisfold = !tisfold"
            ></su-button>
            <su-item
              :data="todayTasks.done"
              title="content"
              other="listName"
              :activedId="activedId"
              v-if="!tisfold"
              @comp-toggle="tSecondComplete"
              @impt-toggle="tSecondImportToggle"
              @active="handleActive($event)"
            ></su-item>
          </div>
        </section>
        <!-- 明天 -->
        <section class="tomorrow">
          <div class="title">twm</div>
          <div class="item-box">
            <su-item
              :data="tomorrowTasks.plan"
              title="content"
              other="listName"
              :activedId="activedId"
              @comp-toggle="tmFirstComplete"
              @impt-toggle="tmFirstImportToggle"
              @active="handleActive($event)"
            ></su-item>
            <su-button
              :count="tmcount"
              v-if="tmcount"
              @click.native="tmisfold = !tmisfold"
            ></su-button>
            <su-item
              :data="tomorrowTasks.done"
              title="content"
              other="listName"
              :activedId="activedId"
              v-if="!tmisfold"
              @comp-toggle="tmSecondComplete"
              @impt-toggle="tmSecondImportToggle"
              @active="handleActive($event)"
            ></su-item>
          </div>
        </section>
      </main>
      <!-- 添加任务输入框 -->
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
      yesterdayTasks: { plan: [], done: [] },
      todayTasks: { plan: [], done: [] },
      tomorrowTasks: { plan: [], done: [] },

      // 保存被激活的 item 的 tid
      activedId: '-1',

      // 控制折叠 --- 昨天、今天
      yisfold: false,
      tisfold: false,
      tmisfold: false,
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
    ycount() {
      return this.yesterdayTasks.done.length;
    },
    tcount() {
      return this.todayTasks.done.length;
    },
    tmcount() {
      return this.tomorrowTasks.done.length;
    },
  },
  methods: {
    // 任务完成
    // 昨天
    async yFirstComplete(index) {
      Subase.complete.call(
        this,
        this.yesterdayTasks.plan,
        index,
        this.loadTasks
      );
    },
    async ySecondComplete(index) {
      Subase.complete.call(
        this,
        this.yesterdayTasks.done,
        index,
        this.loadTasks
      );
    },
    // 今天
    async tFirstComplete(index) {
      Subase.complete.call(this, this.todayTasks.plan, index, this.loadTasks);
    },
    async tSecondComplete(index) {
      Subase.complete.call(this, this.todayTasks.done, index, this.loadTasks);
    },
    // 明天
    async tmFirstComplete(index) {
      Subase.complete.call(
        this,
        this.tomorrowTasks.plan,
        index,
        this.loadTasks
      );
    },
    async tmSecondComplete(index) {
      Subase.complete.call(
        this,
        this.tomorrowTasks.done,
        index,
        this.loadTasks
      );
    },
    // 切换重要性
    // 昨天
    async yFirstImportToggle(index) {
      Subase.importToggle.call(
        this,
        this.yesterdayTasks.plan,
        index,
        this.loadTasks
      );
    },
    async ySecondImportToggle(index) {
      Subase.importToggle.call(
        this,
        this.yesterdayTasks.done,
        index,
        this.loadTasks
      );
    },
    // 今天
    async tFirstImportToggle(index) {
      Subase.importToggle.call(
        this,
        this.todayTasks.plan,
        index,
        this.loadTasks
      );
    },
    async tSecondImportToggle(index) {
      Subase.importToggle.call(
        this,
        this.todayTasks.done,
        index,
        this.loadTasks
      );
    },
    // 明天
    async tmFirstImportToggle(index) {
      Subase.importToggle.call(
        this,
        this.tomorrowTasks.plan,
        index,
        this.loadTasks
      );
    },
    async tmSecondImportToggle(index) {
      Subase.importToggle.call(
        this,
        this.tomorrowTasks.done,
        index,
        this.loadTasks
      );
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
    // '添加记录'事件处理函数
    async handleEnter(newItem) {
      // newItem.important = true;
      const { data: res } = await this.$http.post('tasks/addTask', newItem);
      if (res.meta.status !== 201) return this.$message.error('添加任务失败！');
      this.loadTasks();
    },
    // 获取数据
    async loadTasks() {
      const { data: res } = await this.$http.get('tasks/getPpf');
      // console.log('enter', res);
      if (res.meta.status !== 200) return this.$message.error('获取数据失败！');

      // 获取数据成功，对数据进行预处理
      this.preProcess('yesterdayTasks', res.data.yTasks);
      this.preProcess('todayTasks', res.data.todayTasks);
      this.preProcess('tomorrowTasks', res.data.tomorrowTasks);
      console.log(
        'done:: ',
        this.yesterdayTasks,
        this.todayTasks,
        this.tomorrowTasks
      );
    },

    // 对数据进行预处理
    preProcess(localTasks, oriTasks) {
      const len = oriTasks.length,
        tasks = { plan: [], done: [] };
      for (let i = 0; i < len; i++) {
        if (oriTasks[i].end_time === '0000-00-00 00:00:00') {
          oriTasks[i].complete = false;
        } else {
          oriTasks[i].complete = true;
        }

        if (oriTasks[i].import === '0') {
          oriTasks[i].import = false;
        } else {
          oriTasks[i].import = true;
        }

        if (oriTasks[i].complete) {
          tasks.done.push(oriTasks[i]);
        } else {
          tasks.plan.push(oriTasks[i]);
        }
      }
      this[localTasks] = tasks;
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
  display: flex;
  justify-content: center;
  flex: 1;
  margin-top: 30px;
  width: 100%;
  overflow: auto;
  -ms-overflow-style: none;
  overflow: -moz-scrollbars-none;
  &::-webkit-scrollbar {
    width: 0;
  }

  section {
    display: flex;
    flex-direction: column;
    flex: 1;
    width: 500px;
    &:not(:last-of-type) {
      padding-right: 10px;
    }
    .title {
      padding-left: 20px;
      margin-bottom: 5px;
      letter-spacing: 2px;
      font-size: 18px;
      text-transform: uppercase;
      flex-shrink: 0;
    }
    .item-box {
      flex: 1;
      overflow: auto;
      -ms-overflow-style: none;
      overflow: -moz-scrollbars-none;
      &::-webkit-scrollbar {
        width: 0;
      }
    }
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