<template>
  <div>
    <Card v-for="topic in topics" :key="topic.id">
        <template #content>
          <span class="topic-date">投稿日：{{moment(topic.created_at)}}</span>
          <h2>
            <router-link :to="`/topic/${topic.id}`">
              {{topic.title}}
            </router-link>
          </h2>
        </template>
    </Card>
    <Paginator :rows="10" :totalRecords="pagination_data.total" @page="onPage($event)"></Paginator>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import moment from 'moment'
import Paginator from 'primevue/paginator'

export default {
  name: 'AllTopics',
  components: {
    Paginator
  },
  data () {
    return {
      topics: [],
      pagination_data: {}
    }
  },
  mounted () {
    this.getAllTopics()
  },
  methods: {
    moment: function (date) {
      return moment(date).format('YYYY/MM/DD HH:mm:SS')
    },
    getAllTopics (page = null) {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          let path = '/api/topics'
          if (page) {
            path += '/' + page + '/'
          }
          console.log(path)
          axios.get(path)
            .then((res) => {
              console.log(res)
              if (res.status === 200) {
                this.topics.splice(0)
                this.topics.push(...res.data.data)
                this.pagination_data = res.data
              } else {
                console.log('取得失敗')
              }
            })
        })
        .catch((err) => {
          alert(err)
        })
    },
    onPage (event) {
      this.getAllTopics(event.page + 1)
    }
  }
}
</script>

<style lang="scss" scoped>
.p-card.p-component {
  margin-bottom: 20px;
}
.p-card-content {
  .topic-date {
    font-size: 80%;
  }
}
</style>
