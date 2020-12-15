<template>
  <div class="alter-box">
    <div class="alter-title">
      <i class="el-icon-plus"></i>
      <span class="title">修改信息</span>
    </div>
    <div class="alter-main">
      <p class="tip-text">请正确填写您要修改的部分，并提交表单。</p>
      <el-form
        :model="queryInfo"
        :rules="rules"
        label-position="left"
        ref="alterForm"
        label-width="80px"
        class="alter-userinfo-form"
      >
        <el-form-item label="用户名" prop="name">
          <el-input
            v-model="queryInfo.name"
            placeholder="请填写用户名，1-12 位"
          ></el-input>
        </el-form-item>
        <el-form-item label="邮箱" prop="email">
          <el-input
            v-model="queryInfo.email"
            placeholder="请输入邮箱"
          ></el-input>
        </el-form-item>
        <el-form-item label="手机号" prop="phone">
          <el-input
            v-model="queryInfo.phone"
            placeholder="请输入手机号"
          ></el-input>
        </el-form-item>
        <el-form-item label="新密码" prop="newPasw">
          <el-input
            v-model="queryInfo.newPasw"
            show-password
            placeholder="请输入新密码，6-16 位"
          ></el-input>
        </el-form-item>
        <el-form-item label="确认密码" prop="checkNewPasw">
          <el-input
            v-model="queryInfo.checkNewPasw"
            show-password
            placeholder="请再次输入新密码，确保两次输入相同"
          ></el-input>
        </el-form-item>
        <el-form-item label="旧密码" prop="oldPasw">
          <el-input
            v-model="queryInfo.oldPasw"
            show-password
            placeholder="请输入旧密码，用于验证您的身份（必填）"
          ></el-input>
        </el-form-item>
        <el-form-item label="头像">
          <el-upload
            class="avatar-uploader"
            :action="uploadURL"
            :headers="headers"
            :show-file-list="true"
            :on-success="handleAvatarSuccess"
            :before-upload="beforeAvatarUpload"
          >
            <img
              v-if="queryInfo.imageUrl"
              :src="queryInfo.imageUrl"
              class="avatar"
            />
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="submitForm('alterForm')"
            >提交</el-button
          >
          <el-button @click="resetForm('alterForm')">重置</el-button>
        </el-form-item>
      </el-form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    let validateName = (rule, value, callback) => {
      if (value && value.length > 12) {
        return callback(new Error('用户名不要超过 12 位'));
      }
      callback();
    };
    let validateEmail = (rule, value, callback) => {
      if (value) {
        const reg = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!reg.test(value)) {
          return callback(new Error('请输入合法的邮箱'));
        }
      }
      callback();
    };
    let validatePhone = (rule, value, callback) => {
      if (value) {
        const reg = new RegExp(
          /^(?:(?:\+|00)86)?1(?:(?:3[\d])|(?:4[5-7|9])|(?:5[0-3|5-9])|(?:6[5-7])|(?:7[0-8])|(?:8[\d])|(?:9[1|8|9]))\d{8}$/
        );
        if (!reg.test(value)) {
          return callback(new Error('请输入合法的大陆手机号'));
        }
      }
      callback();
    };
    let validateNewPasw = (r, v, callback) => {
      this.$refs.alterForm.validateField('checkNewPasw');
      return callback();
    };
    let validateCheckPass = (rule, value, callback) => {
      if (value) {
        if (!this.queryInfo.newPasw) {
          callback(new Error('若要修改密码，请先填写上一项再填此项'));
        } else if (value !== this.queryInfo.newPasw) {
          callback(new Error('两次密码输入不一致，请检查'));
        } else callback();
      } else if (this.queryInfo.newPasw) {
        callback(new Error('请再次输入密码'));
      } else callback();
    };
    return {
      queryInfo: {
        name: '',
        email: '',
        phone: '',
        newPasw: '',
        checkNewPasw: '',
        oldPasw: '',
        imageUrl: '',
        temp_path: '',
      },
      rules: {
        name: [{ validator: validateName, trigger: 'blur' }],
        email: [{ validator: validateEmail, trigger: 'blur' }],
        phone: [{ validator: validatePhone, trigger: 'blur' }],
        newPasw: [
          {
            min: 6,
            max: 16,
            message: '长度在 6 到 16 个字符',
            trigger: 'blur',
          },
          { validator: validateNewPasw, trigger: 'blur' },
        ],
        checkNewPasw: [{ validator: validateCheckPass, trigger: 'blur' }],
        oldPasw: [
          {
            required: true,
            message: '请填写旧密码，用于验证您的身份',
            trigger: 'blur',
          },
          {
            min: 6,
            max: 16,
            message: '长度在 6 到 16 个字符',
            trigger: 'blur',
          },
        ],
      },
      // 图片上传地址
      uploadURL: 'http://localhost/todo/index.php/susu/upload/avatar',
      // 头字段 token
      headers: { Authorization: window.localStorage.getItem('token') },
    };
  },
  methods: {
    // 重置表单
    resetForm(refForm) {
      this.$refs[refForm].resetFields();
    },
    // 提交表单
    async submitForm(refForm) {
      this.$refs[refForm].validate(async (valid) => {
        if (valid) {
          // 发请求
          let newQuery = {};
          // 找出需要修改的项
          Object.keys(this.queryInfo).forEach((key) => {
            if (this.queryInfo[key]) {
              newQuery[key] = this.queryInfo[key];
            }
          });

          // 若没有修改，不发请求
          if (!Object.keys(newQuery).length) return;
          const { data: res } = await this.$http.post('person/alter', newQuery);
          if (res.meta.status === 403) {
            return this.$message.error(res.meta.msg);
          }
          this.$message.success('修改信息成功！');
          location.reload();
          console.log(this.queryInfo);
        } else {
          // 有错
          console.log('error submit');
        }
      });
    },
    // 图片上传成功
    handleAvatarSuccess(res) {
      // console.log(res);
      this.queryInfo.imageUrl = res.data.imageURL;
      this.queryInfo.temp_path = res.data.temp_path;
    },
    // 上传前检查图片
    beforeAvatarUpload(file) {
      const type = file.type;
      const types = [
        'image/jpeg',
        'image/jpg',
        'image/pjpeg',
        'image/png',
        'image/x-png',
      ];
      const isExist = types.indexOf(type) !== -1;
      const isLt2M = file.size / 1024 / 1024 < 2;

      if (!isExist) {
        this.$message.error('请上传 JPG、PNG 格式的图片!');
      }
      if (!isLt2M) {
        this.$message.error('上传头像图片大小不能超过 2MB!');
      }
      return isExist && isLt2M;
    },
  },
};
</script>

<style lang="less" scoped>
.alter-box {
  margin: 40px;
  .alter-title {
    // margin-bottom: 20px;
    font-size: 30px;
    .el-icon-plus {
      color: #aaaaab;
      font-weight: 600;
    }
    .title {
      margin-left: 20px;
      color: #586570;
      font-weight: 700;
    }
  }
  .alter-main {
    .tip-text {
      margin: 20px 0;
      text-align: center;
      font-size: 18px;
      color: #586570;
    }
    /deep/.avatar-uploader .el-upload {
      border: 1px dashed #d9d9d9;
      border-radius: 6px;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      &:hover {
        border-color: #409eff;
      }
    }
    .avatar-uploader-icon {
      font-size: 28px;
      color: #8c939d;
      width: 178px;
      height: 178px;
      line-height: 178px;
      text-align: center;
    }
    .avatar {
      // width: 178px;
      height: 178px;
      display: block;
    }
  }
}
</style>