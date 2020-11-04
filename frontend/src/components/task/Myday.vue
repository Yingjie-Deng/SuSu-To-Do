<template>
  <div class="task-detail-container">
    <div class="task-main">
      <div class="header">
        <h1 class="title">
          <i class="el-icon-sunny" style="color: #b04365"></i>
          <span>我的一天</span>
        </h1>
        <p class="datetime">{{ '日期过滤器' | current }}</p>
      </div>

      <su-item
        :data="tasks"
        title="content"
        other="task"
        @comp-toggle="complete"
        @impt-toggle="importToggle"
        @active="handleActive"
      ></su-item>
      <su-input placeholder="添加任务" :list="taskList" @select-lid="handleSelectLid" :default-item="taskList[4]" @keyup-enter="handleEnter"></su-input>
    </div>

    <div class="su-detail" v-if="showDetail">
      <h1>title</h1>
      <div>{{ oneTask }}</div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showDetail: false,
      oneTask: '',
      oldIndex: -1,
      tasks: [
        { content: '早起', task: '任务', complete: true, import: true },
        {
          content: '高数',
          task: '高等数学（专）',
          complete: true,
          import: true,
        },
        {
          content: '数据库',
          task: '数据库（专）',
          complete: true,
          import: true,
        },
        { content: '语法', task: '英语（专）', complete: false, import: true },
        { content: '框架', task: 'SuSu To-Do', complete: true, import: true },
        { content: '早起', task: '任务', complete: false, import: true },
        { content: '语法', task: '英语（专）', complete: false, import: true },
        { content: '框架', task: 'SuSu To-Do', complete: true, import: true },
        { content: '早起', task: '任务', complete: false, import: true },
        { content: '语法', task: '英语（专）', complete: false, import: true },
        { content: '框架', task: 'SuSu To-Do', complete: true, import: true },
        { content: '早起', task: '任务', complete: false, import: true },
        { content: '语法', task: '英语（专）', complete: false, import: true },
        { content: '框架', task: 'SuSu To-Do', complete: true, import: true },
        { content: '早起', task: '任务', complete: false, import: true },
        { content: '语法', task: '英语（专）', complete: false, import: true },
        { content: '框架', task: 'SuSu To-Do', complete: true, import: true },
        { content: '早起', task: '任务', complete: false, import: true },
      ],
      taskList: [
        { lid: '001', listName: '高等数学（专）' },
        { lid: '002', listName: '数据库（专）' },
        { lid: '003', listName: '英语（专）' },
        { lid: '004', listName: 'SuSu To-Do' },
        { lid: '005', listName: '任务' },
      ],
    };
  },
  methods: {
    complete(index) {
      this.tasks[index].complete = !this.tasks[index].complete;
    },
    importToggle(index) {
      this.tasks[index].import = !this.tasks[index].import;
    },
    handleActive(index) {
      if (index !== -1) {
        this.showDetail = true;
        this.oneTask = this.tasks[index].content;
      } else {
        this.showDetail = false;
      }

      console.log(index);
    },
    handleSelectLid(lid) {
      this.lid = lid;
      console.log(this.lid);
    },
    // 添加记录事件处理函数
    handleEnter(newItem) {
      this.tasks.push(newItem);
    }
  },
  computed: {},
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
.su-item {
  margin-top: 30px;
  width: 100%;
  overflow: auto;
  -ms-overflow-style: none;
  overflow: -moz-scrollbars-none;
  &::-webkit-scrollbar {
    width: 0;
  }
}
.su-detail {
  flex-shrink: 0;
  width: 360px;
  height: 100%; /**container 有1px的边框 因此不用 100vh */
  background: #f5f5f5;
}
</style>