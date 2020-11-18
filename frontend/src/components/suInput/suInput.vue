<template>
  <div class="su-input">
    <input
      type="text"
      class="input"
      :placeholder="reallyPlaceholder"
      v-model="textValue"
      @focus="
        isfocus = true;
        reallyPlaceholder = '';
      "
      @blur="
        isfocus = false;
        reallyPlaceholder = placeholder;
      "
      @keyup.enter="handleEnter"
      @keyup="handleKeyup"
    />
    <!-- 头部图标 -->
    <span class="prefix">
      <i :class="[isfocus ? 'inputting' : 'el-icon-plus']"></i>
    </span>
    <!-- 尾部图标 -->
    <span class="suffix" :style="[textValue ? '' : { display: 'none' }]">
      <el-tooltip
        class="item"
        effect="dark"
        content="展示/收起所有清单"
        placement="top"
      >
        <span class="one" @click="handleListShow">
          <i class="el-icon-s-home"></i>{{ activedListName }}
          <!-- <el-card class="list-box-card" :style="[isShowList ? {display: 'block'} : {display: 'none'}]">
            <div v-for=" (item, index) in list" :key=index class="item">
              {{ item.listName }}
            </div>
          </el-card> -->
        </span>
      </el-tooltip>
      <el-tooltip effect="dark" content="选择日期" placement="top">
        <span class="two" @click="handleDateShow">
          <i class="el-icon-date"></i>
        </span>
      </el-tooltip>
    </span>
    <!-- 任务清单展示 -->
    <el-card
      class="list-box-card"
      :style="[isShowList ? { display: 'block' } : { display: 'none' }]"
    >
      <!-- <div class="item" @click="handleListSelect(defaultList)">
        <i class="el-icon-s-home"></i>{{ defaultList.listName }}
      </div> -->
      <div
        v-for="(item, index) in list"
        :key="index"
        class="item"
        @click="handleListSelect(item)"
      >
        <i class="el-icon-s-order"></i><span>{{ item.listName }}</span>
      </div>
    </el-card>
    <!-- 日期时间组件 -->
    <div
      class="date-time-picker"
      :style="[isShowDate ? { display: 'flex' } : { display: 'none' }]"
    >
      <!-- 开始日期 -->
      <el-card class="start-card">
        <template v-slot:header>
          <div class="clearfix">
            <span>开始时间</span>
          </div>
        </template>
        <div class="date-item" @click="handleStartDatePick(0)">
          <i class="el-icon-sunny"></i><span>现在</span>
          <span class="week">{{ 'today' | week(0) }}</span>
        </div>
        <div class="date-item" @click="handleStartDatePick(1)">
          <i class="el-icon-arrow-right"></i><span>明天</span>
          <span class="week">{{ 'today' | week(1) }}</span>
        </div>
        <div class="date-item" @click="handleStartDatePick(2)">
          <i class="el-icon-d-arrow-right"></i><span>下周</span>
          <span class="week">{{ 'today' | week(11) }}</span>
        </div>
        <div class="date-item">
          <i class="el-icon-date"></i>
          <span>
            <el-date-picker
              v-model="start_time"
              type="datetime"
              placeholder="选择开始日期时间"
              @change="handleStartDatePick"
            >
            </el-date-picker>
          </span>
        </div>
      </el-card>
      <!-- 截止日期 -->
      <el-card class="dead-card">
        <template v-slot:header>
          <div class="clearfix">
            <span>截止时间</span>
          </div>
        </template>
        <div class="date-item" @click="handleDeadlineDatePick(0)">
          <i class="el-icon-sunny"></i><span>今天</span>
          <span class="week">{{ 'today' | week(0) }}</span>
        </div>
        <div class="date-item" @click="handleDeadlineDatePick(1)">
          <i class="el-icon-arrow-right"></i><span>明天</span>
          <span class="week">{{ 'today' | week(1) }}</span>
        </div>
        <div class="date-item" @click="handleDeadlineDatePick(2)">
          <i class="el-icon-d-arrow-right"></i><span>下周</span>
          <span class="week">{{ 'today' | week(11) }}</span>
        </div>
        <div class="date-item">
          <i class="el-icon-date"></i>
          <span>
            <el-date-picker
              v-model="deadline"
              type="datetime"
              prefix-icon=""
              placeholder="选择截止日期时间"
              @change="handleDeadlineDatePick"
            >
            </el-date-picker>
          </span>
        </div>
      </el-card>
    </div>
  </div>
</template>

<script>
import tools from '../../assets/base'
export default {
  // model: {
  //   prop: 'value',
  //   event: 'input',
  // },
  props: ['listProp', 'placeholder', 'value', 'defaultList'],
  data() {
    return {
      textValue: '',
      reallyPlaceholder: this.placeholder,
      // 判断 input 框是否获得焦点
      isfocus: false,
      // 控制清单列表的显示
      isShowList: false,
      // list 清单
      list: null,
      // 被激活的清单名
      activedListName: this.defaultList.listName,
      // 被激活的清单 lid
      activedLid: this.defaultList.lid,
      // 控制日期的显示
      isShowDate: false,
      // 开始时间
      start_time: null,
      // 截止时间
      deadline: null,
    };
  },
  created() {
    // 重新加载该组件时，vuex 已经加载完毕并且无新变化，
    // 侦听器无法为 list 赋值，采取手动为 list 赋值
    // 把默认的‘任务’清单加入到 list 清单中
    if (this.listProp) {
      this.list = this.listProp.map((val) => val);
      this.list.unshift(this.defaultList);
    }
  },
  watch: {
    // 侦听 taskList 的异步获取
    listProp() {
      this.list = this.listProp.map((val) => val);
      this.list.unshift(this.defaultList);
    },
  },
  methods: {
    handleListShow() {
      // this.isfocus = true;
      this.isShowList = !this.isShowList;
      this.isShowDate = false;
    },
    handleDateShow() {
      // this.isfocus = true;
      this.isShowDate = !this.isShowDate;
      this.isShowList = false;
    },
    handleListSelect(item) {
      // emit 返回选中的列表清单 lid
      this.activedListName = item.listName;
      this.activedLid = item.lid;
      this.$emit('select-lid', item.lid);
      this.isShowList = !this.isShowList;
    },
    // 开始日期时间选择
    handleStartDatePick(day) {
      let date = new Date();
      switch (day) {
        case 0:
          this.start_time = date;
          break;
        case 1:
          this.start_time = date.setDate(date.getDate() + 1);
          break;
        case 2: {
          const week = date.getDay();
          this.start_time = date.setDate(date.getDate() + 7 - week);
          break;
        }
        default:
          break;
      }
      // this.isShowDate = false;
      // console.log(day, 'hh' ,event.target.tagName);
    },
    // 截止日期时间选择处理函数
    handleDeadlineDatePick(day) {
      let date = new Date();
      switch (day) {
        case 0:
          this.deadline = date;
          break;
        case 1:
          this.deadline = date.setDate(date.getDate() + 1);
          break;
        case 2: {
          const week = date.getDay();
          this.deadline = date.setDate(date.getDate() + 7 - week);
          break;
        }
        default:
          break;
      }
      // 0.5 秒后再关闭
      setTimeout(() => (this.isShowDate = false), 500);

      // console.log(this.deadline);
    },
    // 回车处理事件（封装数据发回给父组件）
    handleEnter() {
      const newItem = {
        lid: this.activedLid,
        content: this.textValue,
        end_time: '0000-00-00 00:00:00',
        found_time: tools.dateFormat('YYYY-mm-dd HH:MM:SS', new Date()),
        start_time: this.start_time
          ? tools.dateFormat('YYYY-mm-dd HH:MM:SS', new Date(this.start_time))
          : tools.dateFormat('YYYY-mm-dd HH:MM:SS', new Date()),
        deadline: this.deadline
          ? tools.dateFormat('YYYY-mm-dd HH:MM:SS', new Date(this.deadline))
          : tools.dateFormat(
              'YYYY-mm-dd',
              new Date(new Date().setDate(new Date().getDate() + 1))
            ),
      };
      console.log(newItem);
      this.$emit('keyup-enter', newItem);
      this.textValue = '';
    },
    handleKeyup() {
      if (!this.textValue) {
        this.isShowList = false;
        this.isShowDate = false;
      }
    },
  },
};
</script>

<style lang="less" scoped>
.su-input {
  display: flex;
  flex-direction: row;
  // flex: 1;
  height: 50px;
  position: relative;
  background-color: #77777773;
  border-radius: 8px;
  // overflow: hidden;
  .input {
    padding-left: 50px;
    height: 50px;
    line-height: 50px;
    width: 100%;
    border: none;
    outline: none;
    background-color: #ffffff00;
    color: #fff;
    font-size: 16px;

    &::-ms-input-placeholder {
      color: #fff;
    }
    &::-webkit-input-placeholder {
      color: #fff;
    }
    &::input-placeholder {
      color: #fff;
    }
  }
  .prefix {
    position: absolute;
    left: 5px;
    width: 40px;
    height: 100%;
    // line-height: 50px;
    text-align: center;
    i.el-icon-plus {
      width: 40px;
      line-height: 50px;
      font-size: 24px;
      color: #fff;
    }
    i.inputting {
      display: inline-block;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -55%);
      width: 22px;
      height: 22px;
      // line-height: 50px;
      border: 2px solid #fff;
      border-radius: 50%;
      // padding: 10px;
    }
  }
  .suffix {
    flex-shrink: 0;
    // right: 5px;
    height: 100%;
    text-align: center;
    .one,
    .two {
      display: inline-block;
      position: relative;
      padding: 0 10px;
      height: 100%;
      color: #fff;
      line-height: 50px;
      font-size: 16px;
      &:hover {
        background-color: #8181819f;
      }
      i {
        min-width: 30px;
        font-size: 24px;
        line-height: 50px;
      }
    }
  }
  .list-box-card {
    display: none;
    // padding: 10px;
    position: absolute;
    // z-index: 2000;
    top: -10px;
    right: 0;
    width: 200px;
    transform: translate(0px, -100%);
    overflow: hidden;
    /deep/ .el-card__body {
      padding: 0;
    }
    .item {
      padding: 10px;
      cursor: pointer;
      &:hover {
        background-color: #eeeeee;
      }
      border-radius: 3px;
      span {
        margin-left: 5px;
      }
    }
  }
  .date-time-picker {
    display: flex;
    flex: 1;
    flex-direction: row;
    justify-content: space-between;
    position: absolute;
    top: -10px;
    right: 0;
    width: 600px;
    transform: translate(0, -100%);
    overflow: hidden;
    // background-color: #201e1e;
    .start-card,
    .dead-card {
      // flex: 1;
      // display: flex;
      width: 295px;
      /deep/ .el-card__header {
        padding-bottom: 0;
      }
      .date-item {
        // display: flex;
        position: relative;
        flex: 1;
        padding: 10px 0;
        cursor: pointer;
        .week {
          position: absolute;
          right: 0;
          color: #777;
        }
        span:first-of-type {
          position: absolute;
          left: 24px;
        }
      }
      .date-item:last-child {
        height: 45px;
        line-height: 45px;
      }
    }
  }
}
</style>