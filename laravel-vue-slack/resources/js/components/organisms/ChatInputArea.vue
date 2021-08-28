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
      @event:updateTextArea="isDisableSendMessage"
      @blur="isDisableSendMessage"
      class="mt-2"
    />
    <text-area-icons
      class="icon-area"
      :isCancel="isCancel"
      :isMention="isMention"
      :isDiableSendMessageButton="isDiableSendMessageButton"
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
  props: ['channelId', 'channelName', 'content', 'isCancel', 'isUpdate', 'userId', 'messageId', 'mentionUsers', 'parentMessageId', 'isMention'],
  setup(props, context) {
    const chatTextArea = ref(null)
    const mentionUserArea = ref(null)
    const isDiableSendMessageButton = ref(true)

    /**
     * 送信アイコンの活性・非活性設定
     */
    const isDisableSendMessage = () => {
      if (chatTextArea.value.text !== undefined) {
        isDiableSendMessageButton.value = (chatTextArea.value.text.length == 0)
      }
    }

    /**
     * メッセージの送信ボタンを押した時の処理
     */
    const sendMessage = async () => {
      if (props.isUpdate) {
        context.emit('event:updateMessage', props.messageId, chatTextArea.value.text)
      } else {
        isDiableSendMessageButton.value = true
        await CreateMessage(props.channelId, chatTextArea.value.text, props.userId, mentionUserArea.value.mentionUsers, props.parentMessageId)
        chatTextArea.value.text = ''
        mentionUserArea.value.mentionUsers = []
      }
    }

    /**
     * メンションを削除したときにemitする
     * @param {string} mentionUser 削除するユーザー名
     */
    const deleteMentionUser = (mentionUser) => {
      context.emit('evnet:deleteMentionUser', mentionUser)
    }

    return {
      sendMessage,
      chatTextArea,
      mentionUserArea,
      deleteMentionUser,
      isDisableSendMessage,
      isDiableSendMessageButton
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
