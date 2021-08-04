<template>
  <div class="text-center relative">
    <mention-user-area
      ref="mentionUserArea"
      :mentionUsers="mentionUsers"
      @evnet:deleteMentionUser="deleteMentionUser"
    />
    <chat-text-area
      ref="chatTextArea"
      :channelName="channelName"
      :content="content"
      class="mt-2"
    />
    <text-area-icons
      class="icon-area"
      :isCancel="isCancel"
      @event:clickMentionIcon="$emit('event:clickMentionIcon')"
      @event:clickReactionIcon="$emit('event:clickReactionIcon')"
      @event:clickCancelIcon="$emit('event:clickCancelIcon')"
      @event:clickMessageIcon="sendMessage" />
  </div>
</template>
<script>
import { ref } from 'vue'
import { CreateMessage } from '../../apis/message.api.js'
export default({
  props: ['channelId', 'channelName', 'content', 'isCancel', 'isUpdate', 'userId', 'messageId', 'mentionUsers'],
  setup(props, context) {
    const chatTextArea = ref(null)
    const mentionUserArea = ref(null)

    const sendMessage = async () => {
      if (props.isUpdate) {
        context.emit('event:updateMessage', props.messageId, chatTextArea.value.text)
      } else {
        await CreateMessage(props.channelId, chatTextArea.value.text,  props.userId, mentionUserArea.value.mentionUsers)
        chatTextArea.value.text = ''
        mentionUserArea.value.mentionUsers = []
      }
    }

    const deleteMentionUser = (mentionUser) => {
      context.emit('evnet:deleteMentionUser', mentionUser)
    }

    return {
      sendMessage,
      chatTextArea,
      mentionUserArea,
      deleteMentionUser
    }
  }
})
</script>

<style scoped>
.icon-area {
  text-align: right;
  position: absolute;
  height: 40px;
  bottom: 12px;
  right: 18px;
}
</style>
