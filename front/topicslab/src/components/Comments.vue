<template>
  <div>
    <Fieldset v-for="comment in comments" :key="comment.id">
      <template #legend>
        <span>
          <router-link :to="`/user/${comment.user.id}`">{{comment.user.name}}</router-link>
        </span>
        <!-- <span>{{ comment.user.name }}</span> -->
      </template>
      <div class="comment-box">
        <div class="comment-text">
            {{ comment.body }}
        </div>
        <LikeBtn class="like-btn"/>
      </div>
    </Fieldset>
  </div>
</template>

<script>
import LikeBtn from '@/components/LikeBtn'

export default {
  name: 'Comments',
  props: {
    comments: Array
  },
  components: {
    LikeBtn
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
