<template>
  <div class="task-detail-container">
    <div class="task-main">
      <div class="header">
        <h1 class="title">
          <i class="el-icon-star-off" style="color: #b04365"></i>
          <span>{{ list.listName }}</span>
        </h1>
      </div>
      <main class="main">
        <su-item
          :data="tasks.plan"
          title="content"
          other="found_time"
          :actived-id="activedId"
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
          other="end_time"
          :actived-id="activedId"
          v-if="!isfold"
          @comp-toggle="secondComplete"
          @impt-toggle="secondImportToggle"
          @active="handleActive($event)"
        ></su-item>
      </main>
      <el-pagination
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page="queryInfo.pagenum"
        :page-sizes="[10, 15, 20, 50, 100]"
        :page-size="queryInfo.pagesize"
        layout="total, sizes, prev, pager, next, jumper"
        :total="total"
        background
      >
      </el-pagination>
      <su-input
        placeholder="添加任务"
        :list-prop="taskList"
        @select-lid="handleSelectLid"
        :default-list="defaultList"
        @keyup-enter="handleEnter"
      ></su-input>
    </div>

    <su-detail
      v-if="showDetail"
      :detail="activedItem"
      @close="handleActive($event)"
      @delete="deleteTask"
    ></su-detail>
  </div>
</template>

<script>
import Subase from '@/assets/base';
export default {
  data() {
    return {
      showDetail: false,
      tasks: { plan: [], done: [] },
      // 保存被激活的 item 的 tid
      activedId: '-1',
      // 保存被激活的 item 的信息
      activedItem: {},
      // 控制折叠
      isfold: false,
      // 清单对象
      list: {},
      // 保存 lid
      currentLid: '',
      // 分页信息
      queryInfo: {
        // 当前页
        pagenum: 1,
        // 每页条目数
        pagesize: 10,
      },
      // 任务总数
      total: 0,
    };
  },
  created() {
    // 第一次点击时，组件加载，侦听器还没开始工作，手动调用一次
    this.getList();
  },
  mounted() {
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
  watch: {
    $route() {
      // 点击另一个清单时路由变化，组件不重载，监听路由
      // 路由变化意味着加载另一个清单，因此需要重置分页查询信息
      this.queryInfo.pagenum = 1;
      this.queryInfo.pagesize = 10;
      // 加载另一个清单时，将打开的 showDetail 收起来
      this.showDetail = false;
      this.activedId = '-1';
      this.getList();
      this.loadTasks();
    },
    taskList() {
      // 刷新时，列表清单还处于异步加载中，监听 Vuex 中的 taskList
      this.getList();
      this.loadTasks();
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
    async handleActive(tid) {
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
      if (!('lid' in this.queryInfo)) return;
      const { data: res } = await this.$http.get('tasks/listShow', {
        params: this.queryInfo,
      });
      // console.log('enter', res);
      if (res.meta.status !== 200) return this.$message.error('获取数据失败！');
      this.total = Number(res.data.total);
      const mytasks = res.data.tasks,
        len = mytasks.length,
        tasks = { plan: [], done: [] };
      for (let i = 0; i < len; i++) {
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
    // size 处理函数
    handleSizeChange(newSize) {
      this.queryInfo.pagesize = newSize;
      this.loadTasks();
    },
    // 当前页变化处理函数
    handleCurrentChange(newPage) {
      this.queryInfo.pagenum = newPage;
      this.loadTasks();
    },
    // 获取展示的列表信息
    getList() {
      if (!this.$store.state.taskList) return;
      const lid = (this.currentLid = this.$route.params.lid);
      // 删除清单后会重新获取清单列表，会触发 taskList 侦听器，
      // 如果先进入了待删除的清单，在删除后会因重新加载 taskList
      // 触发侦听器后会调用此方法，但已删除此清单，故不存在此时路由所
      // 指向的 lid 会报属性不存在的错误
      let lids = this.$store.state.taskList.map((v) => {
        return v.lid;
      });
      lids.push('all_001');
      if (lids.indexOf(lid) === -1) {
        return this.$router.push('/todo/lists/all_001');
      }

      this.queryInfo.lid = this.currentLid;
      // console.log('showLid:::', this.currentLid);
      if (lid === 'all_001') {
        this.list = this.$store.state.defaultList;
      } else {
        this.list = this.$store.state.taskList.filter(
          (list) => list.lid === lid
        )[0];
      }
    },
    // 获取详细信息
    async detail() {
      const { data: res } = await this.$http.get(
        'tasks/detail?tid=' + this.activedId
      );
      if (res.meta.status !== 200) {
        return this.$message.error('获取任务信息失败！');
      }
      this.activedItem = res.data.detail;
    },
    // 删除任务
    async deleteTask(tid) {
      const { data: res } = await this.$http.get('tasks/delete?tid=' + tid);
      if (res.meta.status !== 204) {
        return this.$message.error('删除失败！');
      }
      this.$message.success('删除成功！');
      this.showDetail = false;
      this.activedId = '-1';
      this.loadTasks();
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
.el-pagination {
  margin: 30px 0;
  // width: 100%;
}
</style>