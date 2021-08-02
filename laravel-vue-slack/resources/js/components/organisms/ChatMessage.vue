<template>
  <div class="border border-b-0">
    <show-date v-if="date !== ''">{{ date }}</show-date>
    <div class="group p-5 pr-0 pt-0 flex hover:bg-gray-100 pt-1 pb-1 mt-1 relative">
      <message-area-icons
        :messageId="messageId"
        :channelId="channelId"
        :isMyMessage="isMyMessage"
        @event:reactionMessage="reactionMessage"
        @event:deleteMessage="deleteMessage"
        @event:editMessage="editMessage"
      />
      <div class="w-12">
        <chat-user-image :image="imagePath" />
      </div>
      <div class="ml-2 w-full">
        <div><chat-user-name>{{ postUserName }}</chat-user-name><chat-user-date>{{ postTime }}</chat-user-date></div>
        <div class="whitespace-pre-wrap break-all" v-show="!isEditMode">{{ content }}</div>
        <chat-input-area
          v-show="isEditMode"
          :messageId="messageId"
          :content="content"
          :isUpdate="true"
          @event:clickCancelIcon="isEditMode = false"
          @event:updateMessage="updateMessage"
          :isCancel="true" />
        <div class="flex">
          <div v-for="reaction in reactions" :key="reaction.id" class="flex mt-1">
            <reaction-circle :number="reaction.number" :icon="reaction.icon" class="mr-1 cursor-pointer" @click="updateReaction(reaction.id)" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { ref } from 'vue'
import { UpdateMessage } from '../../apis/message.api.js'
import { DeleteMessage } from '../../apis/message.api'
import { UpdateReactionNumber } from '../../apis/reaction.api.js'

export default({
  props: ['channelId', 'messageId', 'date', 'imagePath', 'postUserName', 'postTime', 'content', 'reactions', 'isMyMessage', 'userId'],
  setup(props, context) {
    const isEditMode = ref(false)

    const reactionMessage = async (messageId) => {
      context.emit('event:reactionMessage', messageId)
    }

    const deleteMessage = async (messageId, channelId) => {
      await DeleteMessage(messageId, channelId)
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

    const updateReaction = async (reactionId) => {
      await UpdateReactionNumber(reactionId, props.userId)
    }

    return {
      isEditMode,
      reactionMessage,
      deleteMessage,
      editMessage,
      updateMessage,
      updateReaction
    }
  }
})
</script>
