<template>
  <div class="task-detail-container">
    <div class="task-main">
      <h1 class="title">
        <i class="el-icon-star-off" style="color: #b04365"></i>
        <span>重要</span>
      </h1>
      <su-item
        :data="tasks"
        title="content"
        other="task"
        @comp-toggle="complete"
        @impt-toggle="importToggle"
        @active="handleActive"
      ></su-item>
      <su-input placeholder="添加任务" :list="taskList" @select-lid="handleSelectLid" :default-item="taskList[4]"></su-input>
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
      lid: '0',
      // 默认显示的清单
      // defaultList: {lid},
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
.task-main {
  display: block;
  flex: 1;
  overflow: auto;
  &::-webkit-scrollbar {
    width: 0;
  }
  -ms-overflow-style: none;
  overflow: -moz-scrollbars-none;
  // flex-basis: auto;
  // width: 100%;
}
.su-item {
  margin-top: 30px;
  width: 100%;
}
.su-input {
  margin-top: 20px;
  width: 100%;
}
.su-detail {
  flex-shrink: 0;
  width: 360px;
  height: 100%; /**container 有1px的边框 */
  background: #f5f5f5;
}
</style>