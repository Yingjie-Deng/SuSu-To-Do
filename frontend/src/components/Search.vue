<template>
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
          <el-button icon="el-icon-search" @click="getSearchResult"></el-button>
        </template>
      </el-input>
    </div>
    <su-item
      :data="tasks"
      title="content"
      other="listName"
      activedId="-1"
      
    >
    </su-item>
  </div>
</template>

<script>
export default {
  data() {
    return {
      queryInfo: {
        query: '',
        select: '',
      },
      tasks: [],
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
  },
};
</script>

<style lang="less" scoped>
.search-box {
  margin: 40px;
  height: 100%;
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
  position: absolute;
  width: 100%;
}
.su-item {
  height: 100%;
  overflow: auto;
}
</style>