<template>
  <div class="container">
    <div class="login_box">
      <!-- 头像 -->
      <div class="avatar_box">
        <el-avatar
          src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"
          :size="100"
        ></el-avatar>
      </div>
      <div class="title">
        <p>LOGIN IN</p>
      </div>
      <el-form
        ref="logFormRef"
        :model="logForm"
        :rules="logRules"
        status-icon
        label-width="0px"
        class="log_form"
      >
        <el-form-item prop="login_name">
          <el-input
            v-model="logForm.login_name"
            placeholder="手机号/邮箱"
            prefix-icon="el-icon-mobile-phone"
            type="text"
          ></el-input>
        </el-form-item>
        <el-form-item prop="password">
          <el-input
            v-model="logForm.password"
            placeholder="请输入密码"
            prefix-icon="el-icon-lock"
            type="password"
            @keyup.enter.native="logHandle"
          ></el-input>
        </el-form-item>
        <el-form-item class="btns">
          <el-button type="primary" @click="logHandle">LOGIN</el-button>
          <el-button type="info" @click="resetHandle">RESET</el-button>
        </el-form-item>
      </el-form>
      <div class="sign">
        <p>
          <a href="javascript:void(0)">忘记密码</a><span>|</span
          ><a href="javascript:void(0)" @click="register">没有账号</a>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    let validatorLoginName = (rule, value, callback) => {
      // 验证邮箱
      if (
        value.indexOf('@') !== -1 &&
        !/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/.test(value)
      ) {
        callback(new Error('邮箱不正确'));
      } else callback();
    };
    return {
      // 登录表单的数据绑定对象
      logForm: {
        login_name: '',
        password: '',
      },
      logRules: {
        login_name: [
          { required: true, message: '此项不能为空', trigger: 'blur' },
          { validator: validatorLoginName, trigger: 'blur' },
        ],
        password: [
          { required: true, message: '密码不能为空', trigger: 'blur' },
          { min: 3, max: 16, message: '密码在3-16位', trigger: 'blur' },
        ],
      },
    };
  },
  methods: {
    logHandle() {
      this.$refs['logFormRef'].validate(async (valid) => {
        if (!valid) return;
        const {data: res} = await this.$http.post('reg/login', this.logForm);
        // console.log('login--', res);
        if (res.meta.status !== 200) return this.$message.error('登录失败');
        this.$message.success('登陆成功');
        window.localStorage.setItem('token', res.data.token);
        let pre = sessionStorage.getItem('current');
        if (pre) {
          return this.$router.push(pre);
        }
        this.$router.push('/todo/home');
      });
    },
    resetHandle() {
      this.$refs['logFormRef'].resetFields();
    },
    register() {
      this.$router.push('/todo/register');
    },
  },
};
</script>

<style lang="less" scoped>
.container {
  // background-image: linear-gradient(45deg, #658fdd, #ce78b5);
  // height: 100%;
  width: 0;
  height: 0;
  border-top: 50vh solid pink;
  border-left: 50vw solid rgb(131, 204, 211);
  border-bottom: 50vh solid rgb(131, 204, 211);
  border-right: 50vw solid pink;

  .login_box {
    width: 350px;
    height: 600px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 3px;
    background-image: linear-gradient(45deg, #df81b3, #84c2f2);
    .avatar_box {
      position: absolute;
      left: 50%;
      transform: translate(-50%, -50%);
    }
    .title {
      position: absolute;
      left: 50%;
      top: 20%;
      transform: translate(-50%, -50%);
      p {
        font-size: 26px;
        color: #fff;
      }
    }
    .log_form {
      width: 100%;
      padding: 0 20px;
      position: absolute;
      bottom: 26%;
      box-sizing: border-box;
      .btns {
        display: flex;
        justify-content: flex-end;
      }
    }
    .sign {
      position: absolute;
      bottom: 20px;
      left: 50%;
      transform: translate(-50%, -50%);
      a {
        color: powderblue;
        text-decoration: none;
        &:hover {
          color: rgb(131, 204, 211);
          font-weight: 700;
        }
      }
      span {
        margin: 0 15px;
        color: powderblue;
      }
    }
  }
}
</style>