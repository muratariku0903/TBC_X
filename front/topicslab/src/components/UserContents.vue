<template>
  <div>
    <TabView>
      <TabPanel header="トピック">
        <!-- ここに投稿したトピックを表示 -->
        {{userContents}}
      </TabPanel>
      <TabPanel header="コメント">
        <!-- ここにコメントを表示 -->
        <Comments :comments="userContents"/>
      </TabPanel>
    </TabView>
  </div>
</template>

<script>
import TabView from 'primevue/tabview'
import TabPanel from 'primevue/tabpanel'
import Comments from '@/components/Comments'

export default {
  name: 'UserContents',
  components: {
    TabView,
    TabPanel,
    Comments
  }
}
</script>

<style>

</style>
