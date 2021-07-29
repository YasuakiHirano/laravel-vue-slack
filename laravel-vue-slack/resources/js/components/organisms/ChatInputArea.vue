<template>
  <div class="text-center">
    <chat-text-area
      ref="chatTextArea"
      :channelName="channelName"
      :content="content"
      class="mt-2"
    />
    <text-area-icons
      class="icon-area"
      :isCancel="isCancel"
      @event:clickReactionBorderIcon="$emit('event:clickReactionIcon')"
      @event:clickCancelIcon="$emit('event:clickCancelIcon')"
      @event:clickMessageIcon="sendMessage" />
  </div>
</template>
<script>
import { ref } from 'vue'
import { CreateMessage } from '../../apis/message.api.js'
export default({
  props: ['channelId', 'channelName', 'content', 'isCancel', 'isUpdate', 'messageId'],
  setup(props, context) {
    const chatTextArea = ref(null)

    const sendMessage = async () => {
      if (props.isUpdate) {
        context.emit('event:updateMessage', props.messageId, chatTextArea.value.text)
      } else {
        await CreateMessage(props.channelId, chatTextArea.value.text)
        chatTextArea.value.text = ''
      }
    }

    return {
      sendMessage,
      chatTextArea,
    }
  }
})
</script>

<style scoped>
.icon-area {
  text-align: right;
  position: absolute;
  height: 40px;
  bottom: 18px;
  right: 20px;
}
</style>
