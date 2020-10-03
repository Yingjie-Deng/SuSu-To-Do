<template>
  <div class="container">
    <div class="register_box">
      <!-- 头像 -->
      <div class="avatar_box">
        <el-avatar
          src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"
          :size="100"
        ></el-avatar>
      </div>
      <div class="title">
        <p>SIGN UP</p>
      </div>
      <el-form
        ref="regFormRef"
        :model="regForm"
        :rules="regRules"
        status-icon
        label-width="0px"
        class="reg_form"
      >
        <el-form-item prop="name">
          <el-input
            v-model="regForm.name"
            placeholder="请输入用户名"
            prefix-icon="el-icon-user"
          ></el-input>
        </el-form-item>
        <el-form-item prop="phone">
          <el-input
            v-model.number="regForm.phone"
            placeholder="请输入手机号"
            prefix-icon="el-icon-mobile-phone"
            type="text"
          ></el-input>
        </el-form-item>
        <el-form-item prop="email">
          <el-input
            v-model="regForm.email"
            placeholder="请输入邮箱（可选）"
            prefix-icon="el-icon-message"
            type="email"
          ></el-input>
        </el-form-item>
        <el-form-item prop="password">
          <el-input
            v-model="regForm.password"
            placeholder="请输入密码"
            prefix-icon="el-icon-lock"
            type="password"
          ></el-input>
        </el-form-item>
        <el-form-item prop="checkpass">
          <el-input
            v-model="regForm.checkpass"
            placeholder="请确认密码"
            prefix-icon="el-icon-magic-stick"
            type="password"
            @keyup.enter.native="regHandle"
          ></el-input>
        </el-form-item>
        <el-form-item class="btns">
          <el-button type="primary" @click="regHandle">SIGN UP</el-button>
          <el-button type="info" @click="resetHandle">RESET</el-button>
        </el-form-item>
      </el-form>
      <div class="login">
        <p>
          <a href="javascript:void(0)">忘记密码</a><span>|</span
          ><a href="javascript:void(0)" @click="login">已有账号</a>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    let validatorEmail = (rule, value, callback) => {
      // 验证邮箱
      if (
        value &&
        !/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/.test(value)
      ) {
        callback(new Error('邮箱不正确'));
      } else {
        callback();
      }
    };
    let validatorCheckPass = (rule, value, callback) => {
      if (!value) callback(new Error('请再次输入密码'));
      else if (this.regForm.password !== value) {
        callback('两次输入密码不一致!');
      } else callback();
    };
    return {
      // 注册表单的数据绑定对象
      regForm: {
        name: '',
        password: '',
        checkpass: '',
        phone: '',
        email: '',
      },
      regRules: {
        name: [
          { required: true, message: '用户名不能为空', trigger: 'blur' },
          { min: 3, max: 16, message: '用户名在3-16位', trigger: 'blur' },
        ],
        phone: [
          { required: true, message: '手机号不能为空', trigger: 'blur' },
          { type: 'number', message: '手机号必须为数字值' },
        ],
        email: [{ validator: validatorEmail, trigger: 'blur' }],
        password: [
          { required: true, message: '密码不能为空', trigger: 'blur' },
          { min: 3, max: 16, message: '密码在3-16位', trigger: 'blur' },
        ],
        checkpass: [{ validator: validatorCheckPass, trigger: 'blur' }],
      },
    };
  },
  methods: {
    regHandle() {
      this.$refs['regFormRef'].validate(async (valid) => {
        if (!valid) return;
        const {data: res} = await this.$http.post('reg/register', this.regForm);
        console.log(res);
        if (res.meta.status !== 201) return this.$message.error('注册失败');
        this.$message.success('注册成功');
        window.localStorage.setItem('token', res.data.token);
        this.$router.push('/todo/home');
      });
    },
    resetHandle() {
      this.$refs['regFormRef'].resetFields();
    },
    login() {
      this.$router.push('/todo/login');
    }
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

  .register_box {
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
    .reg_form {
      width: 100%;
      padding: 0 20px;
      position: absolute;
      bottom: 10%;
      box-sizing: border-box;
      .btns {
        display: flex;
        justify-content: flex-end;
      }
    }
    .login {
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