<template>
  <app-modal
    :showModal="showModal"
    :showAction="false"
    :showCancel="true"
    :wideDialog="true"
    cancelText="閉じる"
  >
    <template v-slot:app-icon>
      <user-icon class="h-5 w-5" />
    </template>
    <template v-slot:app-title>スレッド</template>
    <template v-slot:app-content>
      <div class="w-full" ref="threadMessageListArea">
        <chat-message
          class="w-full border rounded-lg p-2 mb-3"
          :channelId="channelId"
          :messageId="message.id"
          :date="''"
          :imagePath="message.imagePath"
          :postUserName="message.postUserName"
          :postTime="message.postTime"
          :reactions="message.reactions"
          :mentions="message.mentions"
          :content="message.content"
          :isMyMessage="userName === message.postUserName"
          :userId="userId"
          :messageOnly="true"
        />
      </div>
      <div class="max-h-64 border-2 mb-3">
          todo<br />
      </div>
      <chat-input-area
        class="mb-3"
        ref="threadChatInputArea"
        @event:clickMentionIcon="isShowMentionMember = true"
        @event:clickReactionIcon="isShowEmojiPicker = true"
        :userId="userId"
        :channelId="channelId"
        :channelName="channelName" />
      <div
        class="absolute w-full h-full"
        @click="isShowEmojiPicker = false"
        v-show="isShowEmojiPicker">
      </div>
      <emoji-picker
        class="absolute bottom-20 right-4"
        @event:selectEmoji="inputEmoji"
        :isShow="isShowEmojiPicker" />
      <mention-member-modal
        ref="threadMentionMemberModal"
        :showModal="isShowMentionMember"
        :channelUsers="channelUsers"
        @event:modalClose="isShowMentionMember = false"
        @event:mentionUsers="selectMentionUsers"
      />
    </template>
  </app-modal>
</template>
<script>
import { ref } from 'vue'
export default {
  props: ['showModal', 'message', 'channelUsers', 'channelId', 'channelName', 'userId', 'userName'],
  setup(props, context) {
    const threadChatInputArea = ref(null)
    const isShowMentionMember = ref(false)
    const isShowEmojiPicker = ref(false)

    const selectMentionUsers = (mentionUsers) => {
      threadChatInputArea.value.mentionUserArea.mentionUsers = mentionUsers
      isShowMentionMember.value = false
    }

    const inputEmoji = (emoji) => {
      if (threadChatInputArea.value.chatTextArea.text === undefined || threadChatInputArea.value.chatTextArea.text === null) {
        threadChatInputArea.value.chatTextArea.text = ''
      }

      threadChatInputArea.value.chatTextArea.text += emoji.native
    }

    return {
      threadChatInputArea,
      isShowMentionMember,
      isShowEmojiPicker,
      selectMentionUsers,
      inputEmoji
    }
  },
}
</script>
