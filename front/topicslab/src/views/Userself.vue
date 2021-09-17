<template>
  <div>
    <Card>
      <template #title>
        マイページ
        <div v-if="user.img">
          <img v-bind:src="'http://localhost:8000/storage/user/' + user.img" alt="ユーザー画像" width="50">
        </div>
      </template>
      <template #content>
        {{user.name}}
        <UserContents />
      </template>
      <template #footer>
        <Button label="トピック新規作成" v-on:click="toNewTopic" />
        <Button label="ログアウト" class="p-button-warning" v-on:click="logout" />
        <Button label="サインアウト" class="p-button-danger" v-on:click="withdraw" />
      </template>
    </Card>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import UserContents from '@/components/UserContents'

export default {
  name: 'Userself',
  components: {
    UserContents
  },
  data () {
    return {
      user: {}
    }
  },
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      this.$router.push('login')
      return
    }
    this.getUser()
  },
  methods: {
    toNewTopic () {
      this.$router.push('topic')
    },
    logout () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/logout')
            .then(res => {
              console.log(res)
              localStorage.setItem('authenticated', 'false')
              this.$router.push('/login')
            })
            .catch(err => {
              console.log(err)
              alert('取得失敗')
            })
        })
        .catch((err) => {
          alert(err)
          alert('取得失敗')
        })
    },
    withdraw () {
      //
    },
    getUser () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get('/api/user')
            .then((res) => {
              if (res.status === 200) {
                this.user = res.data
              } else {
                console.log('取得失敗')
                alert('取得失敗')
              }
            })
        })
        .catch((err) => {
          alert(err)
          alert('取得失敗')
        })
    }
  }
}
</script>

<style lang="scss" scoped>
.p-card-footer {
  .p-button {
    margin-right: 10px;
  }
}
</style>
