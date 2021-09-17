<template>
  <div>
    <Fieldset v-for="comment in comments" :key="comment.id">
      <template #legend>
        <span>
          <router-link :to="`/user/${comment.user.id}`">{{comment.user.name}}</router-link>
          <div v-if="comment.user.img">
            <img v-bind:src="'http://localhost:8000/storage/user/' + comment.user.img" alt="ユーザー画像" width="50">
          </div>
        </span>
      </template>
      <div class="comment-box">
        <div class="comment-text">
            {{ comment.body }}
        </div>
        <div class="like_submit_btn" @click="onLikeClick(comment)">
          <LikeBtn :like_cnt="comment.likes_count ?? 0" class="like-btn"/>
        </div>
      </div>
    </Fieldset>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import LikeBtn from '@/components/LikeBtn'

export default {
  name: 'Comments',
  props: {
    comments: Array
  },
  components: {
    LikeBtn
  },
  data () {
    return {
      comment_likes_count: 0
    }
  },
  methods: {
    onLikeClick (comment) {
      console.log(comment.id)
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/comment_like', {
            user_id: comment.user_id,
            comment_id: comment.id
          })
            .then((res) => {
              if (res.status === 201) {
                console.log('コメントに対するいいね送信に成功しました。')
              } else if (res.status === 200) {
                console.log('コメントに対するいいねを外しました。')
              } else {
                this.messages.submit = 'コメントに対するいいね送信に失敗しました。'
              }
            })
            .catch((err) => {
              console.log(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    }
  }
}
</script>

<style lang="scss" scoped>
.p-fieldset {
  margin-top: 20px;
}

.comment-box {
    position: relative;
    .like-btn {
        position: absolute;
        top: 5%;
        right: 0;
    }
}

.comment-text {
  white-space: pre-wrap;
}
</style>
