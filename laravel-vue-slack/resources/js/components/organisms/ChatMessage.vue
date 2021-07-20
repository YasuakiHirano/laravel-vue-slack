<template>
  <div class="border border-b-0">
    <show-date v-if="date !== ''">{{ date }}</show-date>
    <div class="group p-5 pr-0 pt-0 flex hover:bg-gray-100 pt-1 pb-1 mt-1 relative">
      <message-area-icons
        :messageId="messageId"
        :channelId="channelId"
        @event:deleteMessage="deleteMessage"
        @event:editMessage="editMessage"
      />
      <div class="w-12">
        <chat-user-image :image="imagePath" />
      </div>
      <div class="ml-2 w-full">
        <div><chat-user-name>{{ postUserName }}</chat-user-name><chat-user-date>{{ postTime }}</chat-user-date></div>
        <div class="content" v-show="!isEditMode">{{ content }}</div>
        <chat-input-area
          v-show="isEditMode"
          :messageId="messageId"
          :content="content"
          :isUpdate="true"
          @event:clickCancelIcon="isEditMode = false"
          @event:updateMessage="updateMessage"
          :isCancel="true" />
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
import { ref } from 'vue'
import { UpdateMessage } from '../../apis/message.api.js'

export default({
  props: ['channelId', 'messageId', 'date', 'imagePath', 'postUserName', 'postTime', 'content', 'mentions'],
  setup(props, context) {
    const isEditMode = ref(false)

    const deleteMessage = (messageId, channelId) => {
      console.log(messageId)
      context.emit('event:deleteMessage', messageId, channelId)
    }

    const editMessage = () => {
      isEditMode.value = true
    }

    const updateMessage = async (messageId, content) => {
      const updated = await UpdateMessage(messageId, content, props.channelId)
      if (updated) {
        isEditMode.value = false
      }
    }

    return {
      deleteMessage,
      editMessage,
      isEditMode,
      updateMessage
    }
  }
})
</script>
<style>
.content {
  white-space:pre-wrap;
}
</style>
