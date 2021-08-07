<template>
  <div class="fixed inset-0 w-full h-full overflow-y-scroll bg-black bg-opacity-60 z-50 flex items-center justify-center" v-show="showModal">
    <div class="inline-block bg-white rounded-lg w-full max-w-3xl">
      <div class="flex justify-between border-t-0 border-l-0 border-r-0 border w-full p-2">
          <div class="flex p-1">
            <div class="h-10 w-10 rounded-full bg-white border-2 border-gray-800 p-1">
              <speaker-icon />
            </div>
            <div class="text-xl mt-2 ml-2">スレッド</div>
          </div>
          <cancel-icon class="w-7 h-7 cursor-pointer mt-2 mr-1" @click="$emit('event:modalClose')" />
      </div>
      <div class="p-3">
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
        <div class="max-h-60 mb-2 overflow-y-scroll">
            <transition-group name="list" tag="div">
              <div v-for="message in threadMessages" :key="message.id">
                 <chat-message
                 class="mt-5 w-full"
                 :channelId="selectChannel"
                 :messageId="message.id"
                 :date="message.date"
                 :imagePath="message.imagePath"
                 :postUserName="message.postUserName"
                 :postTime="message.postTime"
                 :reactions="message.reactions"
                 :mentions="message.mentions"
                 :content="message.content"
                 :isMyMessage="userName === message.postUserName"
                 :userId="userId"
                 @event:reactionMessage="reactionMessage"
                 @event:threadMessage="threadMessage" />
              </div>
            </transition-group>
        </div>
        <chat-input-area
          ref="threadChatInputArea"
          @event:clickMentionIcon="isShowMentionMember = true"
          @event:clickReactionIcon="isShowEmojiPicker = true"
          :userId="userId"
          :channelId="channelId"
          :channelName="channelName"
          :parentMessageId="message.id" />
        <div
          class="fixed inset-0 w-full h-full overflow-y-scroll bg-black bg-opacity-60 z-50 flex items-center justify-center"
          v-show="isShowEmojiPicker">
          <emoji-picker
            @event:selectEmoji="inputEmoji"
            :isShow="isShowEmojiPicker" />
        </div>
        <mention-member-modal
          ref="threadMentionMemberModal"
          :showModal="isShowMentionMember"
          :channelUsers="channelUsers"
          @event:modalClose="isShowMentionMember = false"
          @event:mentionUsers="selectMentionUsers"
        />
      </div>
    </div>
  </div>
</template>
<script>
import { ref } from 'vue'
import SpeakerIcon from '../atoms/SpeakerIcon.vue'
export default {
  components: { SpeakerIcon },
  props: ['showModal', 'message', 'channelUsers', 'channelId', 'channelName', 'userId', 'userName'],
  setup(props, context) {
    const threadChatInputArea = ref(null)
    const isShowMentionMember = ref(false)
    const isShowEmojiPicker = ref(false)
    const threadMessages = ref([])

    const selectMentionUsers = (mentionUsers) => {
      threadChatInputArea.value.mentionUserArea.mentionUsers = mentionUsers
      isShowMentionMember.value = false
    }

    const inputEmoji = (emoji) => {
      if (threadChatInputArea.value.chatTextArea.text === undefined || threadChatInputArea.value.chatTextArea.text === null) {
        threadChatInputArea.value.chatTextArea.text = ''
      }

      threadChatInputArea.value.chatTextArea.text += emoji.native
      isShowEmojiPicker.value = false
    }

    return {
      threadMessages,
      threadChatInputArea,
      isShowMentionMember,
      isShowEmojiPicker,
      selectMentionUsers,
      inputEmoji
    }
  },
}
</script>
