<template>
  <div>
    <TabView>
      <TabPanel header="トピック">
        ここに投稿したトピックを表示
      </TabPanel>
      <TabPanel header="コメント">
        ここにコメントを表示
      </TabPanel>
    </TabView>
  </div>
</template>

<script>
import TabView from 'primevue/tabview'
import TabPanel from 'primevue/tabpanel'

export default {
  name: 'UserContents',
  components: {
    TabView,
    TabPanel
  }
}
</script>

<style>

</style>
