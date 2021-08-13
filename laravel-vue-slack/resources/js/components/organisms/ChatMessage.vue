<template>
  <div :class="{'': messageOnly, 'border border-b-0' : !messageOnly }">
    <show-date v-if="date !== ''">{{ date }}</show-date>
    <div :class="['group', 'p-5', 'pr-0', 'pt-0', 'flex', 'pt-1', 'pb-1', 'mt-1', 'relative', {'hover:bg-gray-100': !messageOnly}]">
      <message-area-icons
        :show="!messageOnly"
        :messageId="messageId"
        :channelId="channelId"
        :isMyMessage="isMyMessage"
        :showThreadIcon="showThreadIcon"
        @event:reactionMessage="reactionMessage"
        @event:threadMessage="threadMessage"
        @event:deleteMessage="deleteMessage"
        @event:editMessage="editMessage"
      />
      <div class="w-12">
        <chat-user-image :image="imagePath" />
      </div>
      <div class="ml-2 w-full">
        <div><chat-user-name>{{ postUserName }}</chat-user-name><chat-user-date>{{ postTime }}</chat-user-date></div>
        <div class="flex" v-if="(mentions != null || mentions != undefined) && mentions.length !== 0">
          <div v-for="mention in mentions" :key="mention.id" class="flex mb-2">
            <div class="mr-1 text-sm p-1 px-2 bg-green-500 rounded">@{{ mention.user_name }}</div>
          </div>
        </div>
        <div class="whitespace-pre-wrap break-all" v-show="!isEditMode">{{ content }}</div>
        <chat-input-area
          ref="chatInputArea"
          v-show="isEditMode"
          :messageId="messageId"
          :content="content"
          :isUpdate="true"
          :isMention="false"
          @event:clickCancelIcon="isEditMode = false"
          @event:updateMessage="updateMessage"
          @event:clickReactionIcon="$emit('event:updateAreaReaction')"
          :isCancel="true" />
        <div class="flex flex-wrap w-full mt-1">
          <div v-for="reaction in reactions" :key="reaction.id" class="mt-1">
            <reaction-circle :number="reaction.number" :icon="reaction.icon" class="mr-1 cursor-pointer" @click="updateReaction(reaction.id)" />
          </div>
        </div>
        <div v-show="isThreadCount" class="text-sm mt-2 mb-2 text-blue-500 cursor-pointer">
            <div @click="threadMessage(messageId)">{{ isThreadCount }}件の返信</div>
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
  props: ['channelId', 'messageId', 'date', 'imagePath', 'postUserName', 'postTime', 'content', 'reactions', 'mentions', 'isMyMessage', 'isThreadCount', 'userId', 'messageOnly', 'showThreadIcon'],
  setup(props, context) {
    const chatInputArea = ref(null)
    const isEditMode = ref(false)

    const reactionMessage = async (messageId) => {
      context.emit('event:reactionMessage', messageId)
    }

    const threadMessage = async (messageId) => {
      context.emit('event:threadMessage', messageId)
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
      threadMessage,
      deleteMessage,
      editMessage,
      updateMessage,
      updateReaction,
      chatInputArea
    }
  }
})
</script>
