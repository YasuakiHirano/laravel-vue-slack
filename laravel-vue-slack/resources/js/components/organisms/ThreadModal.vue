<template>
  <div class="fixed inset-0 w-full h-full overflow-y-scroll bg-black bg-opacity-60 z-20 flex items-center justify-center" v-show="showModal">
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
        <div class="max-h-60 pt-5 mb-3 border border-t-0 border-l-0 border-r-0 overflow-y-scroll" v-show="threadMessages.length != 0" ref="messageListArea">
            <transition-group name="list" tag="div">
              <div v-for="(threadMessage, index) in threadMessages" :key="threadMessage.id" :ref="chatMessages">
                 <chat-message
                   class="w-full"
                   :channelId="channelId"
                   :messageId="threadMessage.id"
                   :date="threadMessage.date"
                   :imagePath="threadMessage.imagePath"
                   :postUserName="threadMessage.postUserName"
                   :postTime="threadMessage.postTime"
                   :reactions="threadMessage.reactions"
                   :mentions="threadMessage.mentions"
                   :content="threadMessage.content"
                   :isMyMessage="userName === threadMessage.postUserName"
                   :userId="userId"
                   :showThreadIcon="false"
                   @event:updateAreaReaction="updateAreaReaction(index)"
                   @event:reactionMessage="reactionMessage" />
              </div>
            </transition-group>
        </div>
        <chat-input-area
          ref="threadChatInputArea"
          @event:clickMentionIcon="isShowMentionMember = true"
          @event:clickReactionIcon="isShowEmojiPicker = true"
          @evnet:deleteMentionUser="deleteMentionUser"
          :userId="userId"
          :channelId="channelId"
          :channelName="channelName"
          :isMention="true"
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
import { ref, onBeforeUpdate } from 'vue'
import SpeakerIcon from '../atoms/SpeakerIcon.vue'
export default {
  components: { SpeakerIcon },
  props: ['showModal', 'message', 'channelUsers', 'channelId', 'channelName', 'userId', 'userName'],
  setup(props, context) {
    const threadChatInputArea = ref(null)
    const isShowMentionMember = ref(false)
    const isShowEmojiPicker = ref(false)
    const threadMessages = ref([])
    const parentMessageId = ref(0)
    const messageListArea = ref(null)
    const threadMentionMemberModal = ref(null)
    const chatMessage = ref(null)
    const chatMessageItems = ref([])
    let isUpdateEditReaction = false
    let selectChatMessageKey = 0

    onBeforeUpdate(() => {
      chatMessageItems.value = []
    })

    /**
     * スレッドメッセージ一覧のテキストエリアを配列に設定する
     * @param {HTMLElement} el
     */
    const chatMessages = (el) => {
      if (el) {
        chatMessageItems.value.push(el)
      }
    }

    /**
     * 一番下にスクロールさせる処理
     */
    const scrollMessageListArea = () => {
      messageListArea.value.scrollTop = messageListArea.value.scrollHeight;
    }

    /**
     * メンションするユーザーを選択された時の処理
     */
    const selectMentionUsers = (mentionUsers) => {
      threadChatInputArea.value.mentionUserArea.mentionUsers = mentionUsers
      isShowMentionMember.value = false
    }

    /**
     * リアクションボタンを押された時にemitする
     * @param {int} messageId リアクションをつけるメッセージID
     */
    const reactionMessage = (messageId) => {
      context.emit('event:reactionMessage', messageId)
    }

    /**
     * スレッドメッセージ一覧のメッセージ編集でリアクションがクリックされた時
     * @param {int} index 選択したメッセージのキー
     */
    const updateAreaReaction = (index) => {
      selectChatMessageKey = index
      isUpdateEditReaction = true
      isShowEmojiPicker.value = true
    }

    /**
     * テキストエリアの絵文字ピッカーで絵文字の選択時処理
     * @param {object} emoji 絵文字オブジェクト
     */
    const inputEmoji = (emoji) => {
      if (isUpdateEditReaction) {
        chatMessageItems.value[selectChatMessageKey].querySelector("textarea").value += emoji.native
        chatMessageItems.value[selectChatMessageKey].querySelector("textarea").dispatchEvent(new Event('input'))

        isUpdateEditReaction = false
        isShowEmojiPicker.value = false
        selectChatMessageKey = 0;
      } else {
        if (threadChatInputArea.value.chatTextArea.text === undefined || threadChatInputArea.value.chatTextArea.text === null) {
          threadChatInputArea.value.chatTextArea.text = ''
        }

        threadChatInputArea.value.chatTextArea.text += emoji.native
        isShowEmojiPicker.value = false
      }
      threadChatInputArea.value.isDisableSendMessage()
    }

    /**
     * メンションの削除ボタンが押された時の処理
     * @param {string} mentionUser メンションユーザー名
     */
    const deleteMentionUser = (mentionUser) => {
      threadChatInputArea.value.mentionUserArea.mentionUsers = threadChatInputArea.value.mentionUserArea.mentionUsers.filter((user) => { return user !== mentionUser })
      threadMentionMemberModal.value.selectUsers = threadMentionMemberModal.value.selectUsers.filter((user) => { return user !== mentionUser })
    }

    return {
      threadMessages,
      threadChatInputArea,
      isShowMentionMember,
      isShowEmojiPicker,
      reactionMessage,
      selectMentionUsers,
      inputEmoji,
      messageListArea,
      parentMessageId,
      scrollMessageListArea,
      deleteMentionUser,
      threadMentionMemberModal,
      updateAreaReaction,
      chatMessages,
      chatMessage
    }
  },
}
</script>
<style>
.list-enter-active,
.list-leave-active {
  transition: opacity 0.5s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
}
</style>
