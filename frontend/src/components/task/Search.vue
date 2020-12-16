<template>
  <div class="task-detail-container">
    <div class="search-box">
      <div class="search-input">
        <el-input
          placeholder="请输入内容"
          v-model="queryInfo.query"
          class="input-with-select"
          @keyup.native.enter="getSearchResult"
        >
          <template #prepend>
            <el-select
              v-model="queryInfo.select"
              placeholder="请选择"
              @change="getSearchResult"
            >
              <el-option label="全部" value=""></el-option>
              <el-option
                v-for="item in options"
                :key="item.lid"
                :label="item.listName"
                :value="item.lid"
              >
              </el-option>
            </el-select>
          </template>
          <template #append>
            <el-button
              icon="el-icon-search"
              @click="getSearchResult"
            ></el-button>
          </template>
        </el-input>
      </div>
      <su-item
        :data="tasks"
        title="content"
        other="listName"
        :actived-id="activedId"
        @active="handleActive($event)"
        @comp-toggle="complete"
        @impt-toggle="importToggle"
      >
      </su-item>
    </div>

    <!-- 细节展示 -->
    <su-detail
      v-if="showDetail"
      :detail="oneTask"
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
      queryInfo: {
        query: '',
        select: '',
      },
      tasks: [],
      showDetail: false,
      oneTask: {},
      // 保存被激活的 item 的 tid
      activedId: '-1',
      // 控制折叠
      // isfold: false,
    };
  },
  computed: {
    options() {
      if (this.$store.state.taskList) {
        let taskList = JSON.parse(JSON.stringify(this.$store.state.taskList));
        taskList.unshift(this.$store.state.defaultList);
        return taskList;
      }
      return [];
    },
  },
  methods: {
    async getSearchResult() {
      console.log('Search:', this.queryInfo);
      const { data: res } = await this.$http.get('tasks/search', {
        params: this.queryInfo,
      });
      if (res.meta.status !== 200) return this.$message.error('搜索出错');
      this.tasks = res.data.tasks;
    },
    // 激活事件处理程序
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
    // 任务完成
    async complete(index) {
      Subase.complete.call(this, this.tasks, index, this.getSearchResult);
    },
    // 切换重要性
    async importToggle(index) {
      Subase.importToggle.call(this, this.tasks, index, this.getSearchResult);
    },
    // 获取详细信息
    async detail() {
      const { data: res } = await this.$http.get(
        'tasks/detail?tid=' + this.activedId
      );
      if (res.meta.status !== 200) {
        return this.$message.error('获取任务信息失败！');
      }
      this.oneTask = res.data.detail;
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
      this.getSearchResult();
    },
  },
};
</script>

<style lang="less" scoped>
.search-box {
  display: flex;
  flex: 1;
  flex-direction: column;
  margin: 40px;
  // height: 100%;
  width: 0;
  position: relative;
}
// 设置头部下拉框的样式
.el-select /deep/.el-input {
  width: 130px;
}
.input-with-select /deep/.el-input-group__prepend {
  background-color: #fff;
}
.search-input {
  flex-shrink: 0;
  width: 100%;
}
.su-item {
  flex: 1;
  margin-top: 20px;
  height: 100%;
  overflow: auto;
}
.su-detail {
  flex-shrink: 0;
  width: 360px;
  height: 100%; /**container 有1px的边框 因此不用 100vh */
  background: #f5f5f5;
}
</style>