<template>
  <div class="su-detail">
    <h3 class="detail-box-title">我不是标题</h3>
    <div class="content">
      <div class="item">
        <p class="label">内容:</p>
        <p class="value">
          <span><i class="el-icon-edit"></i></span>{{ detail.content }}
        </p>
      </div>
      <div class="item">
        <p class="label">重要性:</p>
        <p class="value">
          <span>
            <i
              :class="{
                'el-icon-star-on': detail.import,
                'important-color': detail.import,
                'el-icon-star-off': !detail.import,
                umimpt: !detail.import,
              }"
            ></i></span
          >{{ detail.import ? '重要' : '不重要' }}
        </p>
      </div>
      <div class="item">
        <p class="label">我的一天:</p>
        <p class="value">
          <span><i class="el-icon-sunny"></i></span
          >{{ detail.myday ? '是' : '不是' }}
        </p>
      </div>
      <div class="item">
        <p class="label">状态:</p>
        <p class="value">
          <span
            ><i
              :class="[
                detail.complete
                  ? 'el-icon-circle-check'
                  : 'el-icon-circle-close',
              ]"
            ></i></span
          >{{ detail.complete ? '已完成' : '未完成' }}
        </p>
      </div>
      <div class="item">
        <p class="label">开始时间:</p>
        <p class="value">
          <span><i class="el-icon-video-play"></i></span>{{ detail.start_time }}
        </p>
      </div>
      <div class="item">
        <p class="label">创建时间:</p>
        <p class="value">
          <span><i class="el-icon-s-flag"></i></span>{{ detail.found_time }}
        </p>
      </div>
      <div class="item deadline">
        <p class="label">截止时间:</p>
        <p class="value">
          <span><i class="el-icon-video-pause"></i></span>{{ detail.deadline }}
        </p>
      </div>
      <div class="item" v-if="detail.complete">
        <p class="label">完成时间:</p>
        <p class="value">
          <span><i class="el-icon-refresh"></i></span>{{ detail.end_time }}
        </p>
      </div>
    </div>
    <!-- 步骤 -->
    <div class="steps">
      <p>步骤功能暂未上线</p>
    </div>

    <!-- 删除 -->
    <div class="delete-bar">
      <div class="close" @click="close">
        <i class="el-icon-arrow-right"></i>
      </div>
      <div class="delete" @click="deleteTask">
        <i class="el-icon-delete"></i>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    detail: { type: Object, required: true },
  },
  data() {
    return {};
  },
  // computed: {
  //   data() {
  //     return this.detail;
  //   },
  // },
  methods: {
    close() {
      this.$emit('close', this.detail.tid);
    },
    deleteTask() {
      this.$Msg
        .confirm(`将永久删除 ${this.detail.content}`, '删除任务', {
          dconfirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning',
        })
        .then(() => {
          // this.$message.success('删除成功！');
          // this.close();
          this.$emit('delete', this.detail.tid);
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: '已取消删除',
          });
        });
    },
  },
};
</script>

<style lang="less" scoped>
.su-detail {
  padding: 10px;
  position: relative;
  .detail-box-title {
    color: #586570;
    letter-spacing: 2px;
    font-style: italic;
  }
  .content {
    margin: 20px 0;
    // padding: 15px 0;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.2);
    .item {
      padding: 10px 10px 10px 20px;
      border-radius: 3px;
      &:hover {
        background-color: rgba(0, 0, 0, 0.13);
        .label {
          color: rgba(32, 32, 32, 0.671);
        }
      }
      .label {
        margin-bottom: 5px;
        color: rgba(0, 0, 0, 0.412);
      }
      .value {
        span {
          margin-right: 10px;
          font-size: 18px;
          text-align: center;
        }
      }
    }
  }
  .delete-bar {
    position: absolute;
    bottom: 0px;
    margin-left: -10px;
    background-color: #fff;
    .close,
    .delete {
      display: inline-block;
      height: 60px;
      font-size: 24px;
      text-align: center;
      line-height: 60px;
      &:hover {
        background-color: rgba(0, 0, 0, 0.109);
        cursor: pointer;
      }
    }
    .close {
      width: 60px;
    }
    .delete {
      width: 300px;
      color: #dc282b;
    }
  }
}

.el-icon-edit {
  color: #a1c56b;
}
.el-icon-circle-check {
  color: #1e704d;
}
.important-color {
  color: #b04365;
  font-size: 22px;
}
.el-icon-sunny {
  color: #d76302;
}
.el-icon-s-flag {
  color: #f4968a;
}
.el-icon-circle-close,
.deadline {
  color: #dc282b;
}
.el-icon-video-play {
  color: #8fa7ec;
}
</style>