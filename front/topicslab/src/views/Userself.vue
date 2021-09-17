<template>
  <div>
    <Card>
      <template #title>
        マイページ
        <div v-if="this.userContents.img">
          <img v-bind:src="'http://localhost:8000/storage/user/' + this.userContents.img" alt="ユーザー画像" id="user-image">
        </div>
      </template>
      <template #content>
        {{this.userContents.name}}
        <UserContents :userContents="this.userContents"/>
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
      userContents: {}
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
                axios.get(`/api/user/${res.data.id}`)
                  .then((res) => {
                    if (res.status === 200) {
                      this.userContents = res.data[0]
                      console.log(this.userContents)
                    } else {
                      console.log('取得失敗')
                      alert('取得失敗')
                    }
                  })
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
#user-image{
  width: 120px;
  height: 120px;
  border-radius: 50%;
  border: 3px solid #595959;
}
</style>
