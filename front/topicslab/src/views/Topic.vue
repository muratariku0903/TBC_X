<template>
  <div>
    <Card>
      <template #title>
        {{topic.title}}
      </template>
      <template #content>
        <div class="body-text">
          {{topic.body}}
        </div>
      </template>
      <template #footer>
        <div class="box">
          <span>
            <router-link :to="`/user/${user.id}`">{{user.name}}</router-link>
          </span>
          <LikeBtn v-on:click="like_submit"/>
        </div>
      </template>
    </Card>
    <Comments :comments="this.comments" />
    <CommentForm :topicId="this.topic.id" @sentComment="receiveComment" />
  </div>
</template>

<script>
import axios from '@/supports/axios'
import Comments from '@/components/Comments'
import CommentForm from '@/components/CommentForm'
import LikeBtn from '@/components/LikeBtn'

export default {
  name: 'Topic',
  components: {
    Comments,
    CommentForm,
    LikeBtn
  },
  data () {
    return {
      topic: {},
      user: {},
      comments: [],
      id: null,
      messages: {
        submit: ''
      }
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
    this.getTopic()
  },
  methods: {
    getTopic () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get(`/api/topic/${this.id}`)
            .then((res) => {
              if (res.status === 200 && res.data.length === 1) {
                this.topic = res.data[0]
                this.user = this.topic.user
                this.comments.splice(0)
                this.comments.push(...this.topic.comments)
              } else {
                console.log('取得失敗')
              }
            })
            .catch((err) => {
              console.log(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    },
    receiveComment (comment) {
      this.comments.push(comment)
    },
    like_submit () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/topic_like', {
            user_id: this.user.id,
            topic_id: this.topic.id
          })
            .then((res) => {
              if (res.status === 201) {
                console.log('いいね送信に成功しました。')
              } else if (res.status === 200) {
                console.log('いいねを外しました。')
              } else {
                this.messages.submit = 'いいね送信に失敗しました。'
              }
            })
            .catch((err) => {
              console.log(err)
              this.messages.submit = 'いいね送信に失敗しました。'
            })
        })
        .catch((err) => {
          alert(err)
        })
    }
  }
}
</script>

<style scoped>
.body-text {
  white-space:pre-wrap;
}
.p-card-footer span {
  text-align: right;
  display: block;
}
</style>
