<template>
  <div>
    <Card v-for="topic in topics" :key="topic.id">
        <template #content>
          <span class="topic-date">投稿日：{{moment(topic.created_at)}}</span>
          <h2>
            <router-link :to="`/topic/${topic.id}`" id="topicsLink">
              {{topic.title}}
            </router-link>
          </h2>
          <template v-if="topic.img">
            <img v-bind:src="'http://localhost:8000/storage/' + topic.img" alt="画像" width="250">
          </template>
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
    console.log(this.topics)
  },
  methods: {
    moment: function (date) {
      return moment(date).format('YYYY/MM/DD HH:mm')
    },
    getAllTopics (page = null) {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          let path = '/api/topics'
          if (page) {
            path += '/' + page + '/'
          }
          axios.get(path)
            .then((res) => {
              console.log(res)
              if (res.status === 200) {
                this.topics.splice(0)
                this.topics.push(...res.data.data)
                this.pagination_data = res.data
              } else {
                console.log('取得失敗')
                alert('取得失敗')
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
#topicsLink{
  text-decoration: none;
  font-size: 28px;
  color: black;
  position: relative;
  display: inline-block;
  transition: .3s;
}
#topicsLink::after{
  position: absolute;
  bottom: 0;
  left: 50%;
  content: '';
  width: 0;
  height: 2px;
  background-color: #595959;
  transition: .3s;
  transform: translateX(-50%);
}
#topicsLink:hover::after{
  width: 100%;
}
#topicsLink:hover{
  opacity: 0.7;
}
</style>
