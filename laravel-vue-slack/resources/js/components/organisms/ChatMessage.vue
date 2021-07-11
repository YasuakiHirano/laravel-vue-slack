<template>
  <div class="border border-b-0">
    <show-date>{{ date }}</show-date>
    <div class="group p-5 pt-0 flex hover:bg-gray-100 pt-1 pb-1 mt-1 relative">
      <message-area-icons />
      <div class="w-12">
        <chat-user-image :image="imagePath" />
      </div>
      <div class="ml-2">
        <div><chat-user-name>{{ postUserName }}</chat-user-name><chat-user-date>{{ postTime }}</chat-user-date></div>
        <div v-html="content"></div>
        <div class="flex">
          <div v-for="mention in mentions" :key="mention.id" class="flex mt-1">
            <reaction-circle :number="mention.number" :icon="mention.icon" class="mr-1" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default({
  props: ['date', 'imagePath', 'postUserName', 'postTime', 'content', 'mentions']
})
</script>
