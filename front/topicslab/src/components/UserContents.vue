<template>
  <div>
    <TabView>
      <TabPanel header="トピック">
        <Card v-for="topic in userContents.topics" :key="topic.id">
            <template #content>
            <span class="topic-date">投稿日：{{moment(topic.created_at)}}</span>
            <h2>
              <router-link :to="`/topic/${topic.id}`" id="topicsLink">
                {{topic.title}}
              </router-link>
            </h2>
            </template>
        </Card>
      </TabPanel>
      <TabPanel header="コメント">
        <Card v-for="comment in userContents.comments" :key="comment.id">
            <template #content>
            <span class="comment-date">投稿日：{{moment(comment.created_at)}}</span>
            <h3>
              <router-link :to="`/topic/${comment.topic_id}`" id="topicsLink">
                {{comment.body}}
              </router-link>
            </h3>
            </template>
        </Card>
      </TabPanel>
      <TabPanel header="自己紹介">
        {{userContents.intro}}
      </TabPanel>
    </TabView>
  </div>
</template>

<script>
import TabView from 'primevue/tabview'
import TabPanel from 'primevue/tabpanel'
import moment from 'moment'

export default {
  name: 'UserContents',
  props: {
    userContents: Object
  },
  components: {
    TabView,
    TabPanel
  },
  methods: {
    moment: function (date) {
      return moment(date).format('YYYY/MM/DD HH:mm')
    }
  }
}
</script>

<style>

</style>
