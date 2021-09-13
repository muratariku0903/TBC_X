<template>
  <Button icon="pi pi-heart" class="p-button-raised p-button-rounded like_btn" />
</template>

<script>
import Button from 'primevue/button'

export default {
  name: 'LikeBtn',
  coponents: {
    Button
  }
}
</script>

<style scoped>
.like_btn {
    background-color: pink;
}
</style>
