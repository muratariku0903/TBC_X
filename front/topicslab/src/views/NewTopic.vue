<template>
  <Card>
    <template #title>
      新しいTopicを投稿しよう
    </template>
    <template #content>
      <div class="p-field">
        <label for="title">Topicタイトル</label>
        <InputText v-model="title" id="title" type="text" aria-describedby="title-help" />
        <span class="error-message">{{messages.title}}</span>
      </div>
      <div class="p-field">
        <label for="title">Topic内容</label>
        <Textarea v-model="body" :autoResize="true" rows="10" />
        <span class="error-message">{{messages.body}}</span>
      </div>
      <div class="p-field">
        <label for="title">画像</label>
        <label for="img" class="button">
          ファイルを選択
          <input id="img" type="file" name="img" @change="onFileChange">
        </label>
        <span class="error-message">{{messages.file}}</span>
      </div>
      <div class="p-field">
        <Button icon="pi pi-check" label="保存" v-on:click="submit" />
        <span class="error-message">{{messages.submit}}</span>
      </div>
    </template>
  </Card>
</template>

<script>
import axios from '@/supports/axios'

export default {
  name: 'NewTopic',
  Headers: {
    'Content-Type': 'multipart/form-data'
  },
  data () {
    return {
      title: '',
      body: '',
      file: null,
      messages: {
        submit: '',
        title: '',
        body: '',
        file: ''
      }
    }
  },
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      this.$router.push('login')
    }
  },
  methods: {
    submit () {
      const title = this.title.trim()
      if (!title) {
        this.messages.title = '未記入(空白のみ)は送信できません。'
      }
      const body = this.body.trim()
      if (!body) {
        this.messages.body = '未記入(空白のみ)は送信できません。'
      }

      if (!title || !body) return

      console.log(this.file)
      const formData = new FormData()
      formData.append('title', title)
      formData.append('body', body)
      formData.append('img', this.file)
      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }

      console.log(formData)

      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/topic', formData, config)
            .then((res) => {
              if (res.status === 201) {
                console.log('トピック作成しました。')
              } else {
                this.messages.submit = '送信に失敗しました。'
              }
            })
            .catch((err) => {
              console.log(err)
              this.messages.submit = '送信に失敗しました。'
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

<style scoped>
.p-field * {
  display: block;
  width: 100%;
}
.error-message{
  color: red;
  margin-top: 10px;
}
.button{
  background: #fff;
  color: #595959;
  text-align: center;
  font-weight: bold;
  border-radius: 3px;
  border: 2px solid #595959;
  cursor: pointer;
  padding: 15px 30px;
  margin: 0 10px 0 0;
  display: inline-block;
  transition: .3s;
}
.button:hover{
  color: #fff;
  background: #595959;
}
.button input{
  display: none;
}
</style>
