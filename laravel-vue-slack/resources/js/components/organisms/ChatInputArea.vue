<template>
  <div class="text-center">
    <chat-text-area ref="chatTextArea" :channelName="channelName" class="mt-2" />
    <text-area-icons class="icon-area" @event:clickMessageIcon="sendMessage" />
  </div>
</template>
<script>
import { ref } from 'vue'
import { CreateMessage } from '../../apis/message.api.js'
export default({
  props: ['channelName'],
  setup() {
    const chatTextArea = ref(null)

    const sendMessage = async () => {
      await CreateMessage(1, chatTextArea.value.text)
      chatTextArea.value.text = ''
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
  width: 145px;
  height: 40px;
  bottom: 18px;
  right: 20px;
}
</style>
