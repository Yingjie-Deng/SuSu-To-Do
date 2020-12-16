<template>
  <div class="su-button" @click="isfold = !isfold">
    <span class="prefix" :class="[isfold ? 'rotate' : '']"
      ><i class="el-icon-arrow-down"></i
    ></span>
    <p class="content">
      <slot>已完成</slot>
    </p>
    <span class="suffix">{{count}}</span>
  </div>
</template>

<script>
export default {
  props: ['count'],
  data() {
    return {
      // 控制倒三角的方向
      isfold: false,
    };
  },
};
</script>

<style lang="less" scoped>
.su-button {
  display: inline-flex;
  justify-content: center;
  align-items: center;
  margin: 15px 0;
  height: 28px;
  background: #bebebe75;
  &:hover {
    background: #bebebeb9;
    cursor: pointer;
  }
  border-radius: 5px;
  color: #586570;
}
.content {
  display: inline-block;
}
.prefix,
.content,
.suffix {
  padding: 2px 5px;
}
.prefix {
  transition: transform 0.2s linear 0s;
}
.rotate {
  transform: rotate(-90deg);
}
</style>