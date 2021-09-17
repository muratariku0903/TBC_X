<template>
  <div>
    <Card>
      <template #title>
        新規登録
      </template>
      <template #content>
        <div class="fields">
          <div class="p-field">
            <label for="name">ユーザー名</label>
            <InputText id="name" type="text" v-model="name" />
          </div>
          <div class="p-field">
            <label for="email">メールアドレス</label>
            <InputText id="email" type="email" v-model="email" />
          </div>
          <div class="p-field">
            <label for="password">パスワード</label>
            <InputText id="password" type="password" v-model="password" />
          </div>
          <div class="p-field">
            <label for="img">画像</label>
            <input type="file" name="img" @change="onFileChange">
          </div>
        </div>
        <span>{{message}}</span>
        <div class="p-field">
          <Button icon="pi pi-check" label="登録" v-on:click="register" />
        </div>
      </template>
    </Card>
  </div>
</template>

<script>
import axios from '@/supports/axios'

export default {
  name: 'Register',
  data () {
    return {
      name: '',
      email: '',
      password: '',
      file: null,
      message: ''
    }
  },
  methods: {
    register () {
      const name = this.name.trim()
      const email = this.email.trim()
      const password = this.password.trim()
      if (!name || !email || !password) {
        this.message = '全て必須項目です。'
        return
      }

      const formData = new FormData()
      formData.append('name', name)
      formData.append('email', email)
      formData.append('password', password)
      formData.append('img', this.file)
      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }

      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/register', formData, config)
            .then((res) => {
              if (res.status === 201) {
                alert('ユーザー登録成功')
                this.$router.push('/login')
              } else {
                this.message = 'ユーザー登録に失敗しました。'
              }
            })
            .catch((err) => {
              console.log(err)
              this.message = 'ユーザー登録に失敗しました。'
            })
        })
        .catch((err) => {
          alert(err)
        })
    },
    onFileChange (e) {
      this.file = e.target.files[0]
    }
  }
}
</script>

<style lang="scss" scoped>
.p-card-content {
  .fields {
    text-align: center;
  }

  .p-field {
    display: block;

    label {
      display: inline-block;
      width: 10em;
      margin-bottom: 10px;
    }

    .p-button {
      margin-top: 20px;
      display: block;
      width: 100%;
    }
  }

  span {
    color: red;
  }
}
</style>
