<template>
  <div class="su-item">
    <div
      class="task-item"
      :class="{ 'active-bg': item.tid === activedId }"
      v-for="(item, index) in data"
      :key="item.tid"
      @click="active(item.tid)"
    >
      <!-- 切换 完成 / 未完成 的按钮 -->
      <div class="radio" @click.stop="completeToggle(index, item.complete)">
        <el-button
          size="mini"
          :class="[item.complete ? 'trim-padding' : '']"
          circle
        >
          <i :class="[item.complete ? 'el-icon-success' : '']"></i>
        </el-button>
      </div>
      <!-- 展示任务内容 -->
      <div class="content">
        <h2 class="item_title" :class="{ 'delete-line': item.complete }">
          {{ item[title] }}
        </h2>
        <p class="task">{{ item[other] }}</p>
      </div>
      <!-- 切换重要性的按钮 -->
      <div class="import" @click.stop="importToggle(index)">
        <i :class="[item.import ? 'el-icon-star-on' : 'el-icon-star-off']"></i>
      </div>
      <!-- <audio ref="audio">
        <source src="../../assets/complete.wav" type="audio/wav" />
      </audio> -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // oldIndex: -1,
      // showDetail: false,
      // // 记录上一次监听到的值
      // oldLinsten: '',
    };
  },
  props: ['data', 'title', 'other', 'activedId'],
  watch: {
    // listener() {
    //   if (
    //     this.oldLinsten !== '' &&
    //     this.listener.substr(0, 4) !== this.oldLinsten.substr(0, 4)
    //   ) {
    //     this.oldIndex = -1;
    //     this.showDetail = false;
    //   }
    //   this.oldLinsten = this.listener;
    // },
  },
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
    // 触发点击事件（发回 tid 用于展示详细信息）
    active(tid) {
      return this.$emit('active', tid);
    },

    // 判断任务项是否激活
    // isActive(index) {
    //   if (index === this.oldIndex) {
    //     this.showDetail = !this.showDetail;
    //   } else {
    //     this.showDetail = true;
    //   }

    //   this.oldIndex = index;
    //   return this.showDetail;
    // },

    // 完成时播放音效
    play(index, complete) {
      if (!complete) {
        // const audio = this.$refs.audio;
        // const body = this.$refs.raudioDiv;
        // // console.log('body--audio::', body, audio);
        // body.appendChild(audio);
        // let raudio = body.getElementsByTagName('audio');
        // raudio = raudio[raudio.length -1];
        // raudio.play();
        // setTimeout(() => {
        //   const body = this.$refs.raudioDiv;
        //   const daudio = body.getElementsByTagName('audio')[0];
        //   // body.removeChild(daudio);
        //   console.log(daudio);
        // }, 1200);

        // const body = document.getElementsByTagName('body')[0];
        // const audio = document.createElement('AUDIO');
        // const source = document.createElement('SOURCE');
        // source.setAttribute('src', '/media/complete.22b3e387.wav');
        // source.setAttribute('type', 'audio/wav');
        // audio.appendChild(source);
        // body.appendChild(audio);
        // let raudio = body.getElementsByTagName('audio');
        // raudio = raudio[raudio.length - 1];
        // console.log(raudio);
        // raudio.play();
        // setTimeout(() => {
        //   const body = document.getElementsByTagName('body')[0];
        //   const daudio = body.getElementsByTagName('audio');
        //   body.removeChild(daudio[0]);
        // }, 1200);

        // 'http://127.0.0.1:1107/media/complete.22b3e387.wav'
        // '../media/complete.22b3e387.wav'
        // '@/assets/complete.wav'
        const audio = new Audio(
          'http://localhost/todo/application/views/complete.wav'
        );
        audio.src = 'http://localhost/todo/application/views/complete.wav';
        audio.load();
        const aduioPromise = audio.play();
        if (aduioPromise) {
          aduioPromise
            .then(() => {
              // setTimeout(() => {
              //   console.log('Audio:: done');
              // }, audio.duration * 1000);
              console.log('Audio::done');
            })
            .catch((e) => {
              console.log('Audio-Error: ', e);
            });
        }
      }
    },
  },
};
</script>

<style lang="less" scoped>
.task-item {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 60px;
  padding: 0 20px 0 10px;
  margin: 2px 0;
  background: #fff;
  border-radius: 5px;
  transition: background 0.2s linear;
  -moz-transition: background 0.2s linear; /* Firefox 4 */
  -webkit-transition: background 0.2s linear; /* Safari 和 Chrome */
  -o-transition: background 0.2s linear;
  &:hover {
    background: #eeeeee;
  }
  .radio {
    display: flex;
    flex-shrink: 0;
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
    padding: 10px 10px 0 10px;
    flex: 1;
    height: 60px;
    overflow: hidden;
    .item_title {
      width: 100%;
      font-size: 16px;
      font-weight: 500;
      text-overflow: ellipsis;
      white-space: nowrap;
      overflow: hidden;
    }
    .task {
      font-size: 12px;
      color: #737373;
    }
  }
  .import {
    flex: 0;
    line-height: 60px;
    width: 24px;
    font-size: 24px;
    text-align: center;
  }
}
/** 完成或激活后的样式 -- 删除线、背景 */
.active-bg {
  background: #eeeeee;
}
.delete-line {
  text-decoration: line-through;
  color: #6e6e6e;
}
/**重要 ‘星’ 的样式，金色 */
.el-icon-star-on {
  color: #b04365;
}
.el-icon-star-off {
  font-size: 20px;
}
</style>