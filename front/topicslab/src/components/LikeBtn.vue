<template>
  <Button icon="pi pi-heart" class="p-button-raised p-button-rounded like_btn" />
  <span>{{like_cnt}}</span>
</template>

<script>
import Button from 'primevue/button'

export default {
  name: 'LikeBtn',
  props: {
    like_cnt: Number
  },
  coponents: {
    Button
  }
}
</script>

<style scoped>
.like_btn {
    background-color: pink;
}
span {
    color: pink;
}
</style>
