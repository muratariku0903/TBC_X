<template>
  <div>
    <Card>
      <template #content>
        {{user.name}}
        <template v-if="user.img">
          <img v-bind:src="'http://localhost:8000/storage/user/' + user.img" alt="ユーザー画像" width="50">
        </template>
        <UserContents :userContents="this.user" />
        <!-- <Comments :comments="this.user.comments" /> -->
      </template>
    </Card>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import UserContents from '@/components/UserContents'
// import Comments from '@/components/Comments'

export default {
  name: 'user',
  components: {
    UserContents
    // Comments
  },
  data () {
    return {
      id: null,
      user: {}
      // comments: []
    }
  },
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      this.$router.push('/login')
      return
    }

    this.id = this.$route.params.id
    if (!this.id) {
      alert('不正なIDです。')
    }
    this.getUser()
  },
  methods: {
    getUser () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get(`/api/user/${this.id}`)
            .then((res) => {
              console.log(res)
              if (res.status === 200) {
                this.user = res.data[0]
                console.log(this.user)
              } else {
                console.log('取得失敗')
                alert('取得失敗')
              }
            })
            .catch((err) => {
              console.log(err)
              alert(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    }
  }
}
</script>
