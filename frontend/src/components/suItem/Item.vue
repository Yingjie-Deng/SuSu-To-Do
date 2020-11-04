<template>
  <div class="su-item">
    <div
      class="task-item"
      :class="{ 'active-bg': index === oldIndex && showDetail }"
      v-for="(item, index) in data"
      :key="index"
      @click="active(index)"
    >
      <div class="radio" @click.stop="completeToggle(index, item.complete)">
        <el-button
          size="mini"
          :class="[item.complete ? 'trim-padding' : '']"
          circle
        >
          <i :class="[item.complete ? 'el-icon-success' : '']"></i>
        </el-button>
      </div>
      <div class="content">
        <h2 class="item_title" :class="{ 'delete-line': item.complete }">
          {{ item[title] }}
        </h2>
        <p class="task">{{ item[other] }}</p>
      </div>
      <div class="import" @click.stop="importToggle(index)">
        <i :class="[item.import ? 'el-icon-star-on' : 'el-icon-star-off']"></i>
      </div>
      <audio ref="audio">
        <source src="../../assets/complete.wav" type="audio/wav">
    </audio>
    </div>
    
  </div>
</template>

<script>
export default {
  data() {
    return {
      oldIndex: -1,
      showDetail: false,
    };
  },
  props: ['data', 'title', 'other'],
  methods: {
    // 自定义事件用于切换未完成/完成
    completeToggle(index, complete) {
      this.play(index, complete);
      this.$emit('comp-toggle', index);
    },
    // 自定义事件用于切换重要/非重要
    importToggle(index) {
      this.$emit('impt-toggle', index);
    },
    // 展开任务
    active(index) {
      if (this.isActive(index)) {
        return this.$emit('active', index);
      }
      return this.$emit('active', -1);
    },

    // 判断任务项是否激活
    isActive(index) {
      if (index === this.oldIndex) {
        this.showDetail = !this.showDetail;
      } else {
        this.showDetail = true;
      }

      this.oldIndex = index;
      return this.showDetail;
    },

    // 完成时播放音效
    play(index, complete) {
      if (!complete) {
        this.$refs.audio[index].play();
      }
    }
  },
};
</script>

<style lang="less" scoped>
.task-item {
  height: 60px;
  padding: 0 20px 0 10px;
  margin: 2px 0;
  background: #fff;
  border-radius: 5px;
  &:hover {
    background: #f5f5f5;
  }
  .radio {
    display: flex;
    justify-content: center;
    align-items: center;
    float: left;
    width: 40px;
    height: 60px;
    .el-button {
      padding: 10px;
      border: 2px solid #808080;
    }
    .el-button.trim-padding {
      padding: 0;
      border: none;
    }
    i.el-icon-success {
      font-size: 28px;
      color: #687681;
    }
  }
  .content {
    padding: 10px 0 0 10px;
    float: left;
    height: 60px;
    .item_title {
      font-size: 16px;
      font-weight: 500;
    }
    .task {
      font-size: 12px;
      color: #737373;
    }
  }
  .import {
    float: right;
    line-height: 60px;
    width: 24px;
    font-size: 24px;
  }
}
/** 完成或激活后的样式 -- 删除线、背景 */
.active-bg {
  background: #f5f5f5;
}
.delete-line {
  text-decoration: line-through;
  color: #6e6e6e;
}
/**重要 ‘星’ 的样式，金色 */
.el-icon-star-on {
  color: #b04365;
}
</style>