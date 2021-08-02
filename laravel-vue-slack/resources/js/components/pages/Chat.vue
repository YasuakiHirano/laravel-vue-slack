<template>
    <div class="main">
        <loading-display :isShow="showLoading" />
        <chat-header class="header" :userName="userName" />
        <side-menu
          class="side-menu"
          :channelId="selectChannel"
          @event:SelectChannel="changeChannel"
          @event:FetchChannels="fetchChannels"
          @event:AddMember="showAddMember = true"
          @event:AddChannel="showAddChannel = true" />
        <div class="message-area">
          <show-channel-name
            :channelId="selectChannel"
            :count="userCount"
            @event:clickCountChannel="isChannelTab = false;showChannelDetail = true;"
            @event:openChannelDetail="isChannelTab = true;showChannelDetail = true;"
            @event:isChannelUpdate="isChannelUpdate"
          >
              <div class="flex">
                <div v-if="isChannelPublic"><hash-icon class="mt-1 w-5 h-5"></hash-icon></div>
                <div v-else><lock-icon class="mt-1 w-5 h-5"></lock-icon></div>
                <div class="mr-1">{{ channelName }}</div>
              </div>
          </show-channel-name>
          <div class="w-full overflow-y-scroll" ref="messageListArea">
            <transition-group name="list" tag="div">
              <div v-for="message in messages" :key="message.id">
                 <chat-message
                 class="mt-5 w-full"
                 :channelId="selectChannel"
                 :messageId="message.id"
                 :date="message.date"
                 :imagePath="message.imagePath"
                 :postUserName="message.postUserName"
                 :postTime="message.postTime"
                 :reactions="message.reactions"
                 :content="message.content"
                 :isMyMessage="userName === message.postUserName"
                 :userId="userId"
                 @event:reactionMessage="reactionMessage" />
              </div>
            </transition-group>
          </div>
          <chat-input-area
            ref="chatInputArea"
            @event:clickReactionIcon="isShowEmojiPicker = true"
            :channelId="selectChannel"
            :channelName="channelName"
            class="mt-2" />
        </div>
        <!--モーダル実装-->
        <!----メンバー招待---->
        <add-member-modal
          :showModal="showAddMember"
          @event:modalAction="sendInvitationMail"
          @event:modalClose="showAddMember = false"
          @event:updateText="updateEmail" />
        <add-member-success-modal
          :showModal="showAddMemberSuccess"
          @event:modalAction="showAddMemberSuccess = false" />
        <!----チャンネル追加---->
        <add-channel-modal
          :showModal="showAddChannel"
          @event:modalClose="showAddChannel = false"
          @event:modalAction="addChannel"
          @event:updateAddChannelName="updateAddChannelName"
          @event:updateAddChannelDescription="updateAddChannelDescription"
          @event:updateAddChannelIsPrivate="updateAddChannelIsPrivate" />
        <add-channel-success-modal
          :showModal="showAddChannelSuccess"
          @event:modalAction="showAddChannelSuccess = false" />
        <!----チャンネル情報表示-->
        <channel-detail-modal
          :showModal="showChannelDetail"
          :isChannelTab="isChannelTab"
          :channelId="selectChannel"
          :channelUsers="channelUsers"
          :description="channelDescription"
          :createUser="channelCreateUser"
          :isChannelPublic="isChannelPublic"
          :channelName="channelName"
          @event:editChannelDescription="showEditChannelDescription = true"
          @event:addChannelMember="showAddChannelMember = true"
          @event:modalAction="showChannelDetail = false" />
        <channel-description-edit-modal
          :showModal="showEditChannelDescription"
          :description="channelDescription"
          @event:modalAction="updateChannelDescription"
          @event:updateDescription="updateDescription"
          @event:modalClose="showEditChannelDescription = false" />
        <channel-add-member-modal
          :showModal="showAddChannelMember"
          :notChannelUsers="notChannelUsers"
          @event:addUsers="channelAddUsers"
          @event:modalClose="showAddChannelMember = false" />
        <emoji-picker
          class="fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center"
          @event:selectEmoji="reactionEmoji"
          :isShow="isShowCenterEmojiPicker" />
        <div
          class="absolute w-full h-full"
          @click="isShowEmojiPicker = false"
          v-show="isShowEmojiPicker">
        </div>
        <emoji-picker
          class="absolute bottom-20 right-4"
          @event:selectEmoji="inputEmoji"
          :isShow="isShowEmojiPicker" />
    </div>
</template>

<script>
import { onMounted, ref, nextTick } from 'vue'
import { FindUser } from '../../apis/user.api.js'
import { SendInvitationMail } from '../../apis/mail.api.js'
import { FetchMessages } from '../../apis/message.api.js'
import { CreateChannel, UpdateChannel } from '../../apis/channel.api.js'
import { CreateChannelUsers, FetchChannelUsers, FetchNotChannelUsers } from '../../apis/channelUser.api.js'
import { CreateOrUpdateReaction } from '../../apis/reaction.api.js'

export default {
  setup(props, context) {
    const userId = ref(0)
    const userName = ref('')
    const userCount = ref(0)
    const email = ref('')
    const channelName = ref('')
    const channelDescription = ref('')
    const channelCreateUser = ref('')
    const channelList = ref('')
    const channelUsers = ref([])
    const notChannelUsers = ref([])
    const isChannelTab = ref(true)
    const isChannelPublic = ref(false)
    const selectChannel = ref(1)
    const messages = ref([])
    const showLoading = ref(true)
    const showAddMember = ref(false)
    const showAddMemberSuccess = ref(false)
    const showChannelDetail = ref(false)
    const showEditChannelDescription = ref(false)
    const showAddChannelMember = ref(false)
    const messageListArea = ref(null)
    const showAddChannel = ref(false)
    const showAddChannelSuccess = ref(false)
    const addChannelName = ref('')
    const addChannelDescription = ref('')
    const addChannelIsPrivate = ref(false)
    const isShowEmojiPicker = ref(false)
    const isShowCenterEmojiPicker = ref(false)
    const selectMessageId = ref(0)
    const chatInputArea = ref(null)

    const updateEmail = (text) => {
      email.value = text.value
    }

    const updateAddChannelName = (text) => {
      addChannelName.value = text.value
    }

    const updateAddChannelDescription = (text) => {
      addChannelDescription.value = text.value
    }

    const updateAddChannelIsPrivate = (value) => {
      addChannelIsPrivate.value = value
    }

    const sendInvitationMail = async () => {
      showAddMember.value = false
      showLoading.value = true
      await SendInvitationMail(email.value)
      showLoading.value = false
      showAddMemberSuccess.value = true
    }

    const addChannel = async () => {
      showAddChannel.value = false
      showLoading.value = true
      await CreateChannel(addChannelName.value, addChannelDescription.value, addChannelIsPrivate.value)
      showLoading.value = false
      showAddChannelSuccess.value = true
    }

    const scrollMessageListArea = () => {
      messageListArea.value.scrollTop = messageListArea.value.scrollHeight;
    }

    const changeChannel = async (channelId) => {
      selectChannel.value = channelId
      await initLoading()
      findChannelName()
    }

    const fetchChannels = (channels) => {
      channelList.value = channels
      findChannelName()
    }

    const findChannelName = () => {
      // チャンネル情報から現在のチャンネル名取得
      const channel = channelList.value.find(channel => channel.id === selectChannel.value)

      channelName.value = channel.name
      channelDescription.value = channel.description
      channelCreateUser.value = channel.create_user
      isChannelPublic.value = channel.is_public ? true : false
    }

    const updateChannelDescription = async () => {
      // チャンネルの説明を更新
      await UpdateChannel(selectChannel.value, null, channelDescription.value, null)
      showEditChannelDescription.value = false
    }

    const updateDescription = (text) => {
      channelDescription.value = text
    }

    const openMembersModal = () => {
      isChannelTab.value = false
      showChannelDetail.value = true
    }

    const isChannelUpdate = (value) => {
      isChannelTab.value = value
    }

    const inputEmoji = (emoji) => {
      if (chatInputArea.value.chatTextArea.text === undefined || chatInputArea.value.chatTextArea.text === null) {
        chatInputArea.value.chatTextArea.text = ''
      }

      chatInputArea.value.chatTextArea.text += emoji.native
    }

    const reactionEmoji = async (emoji) => {
      await CreateOrUpdateReaction(selectMessageId.value, userId.value, emoji.id, emoji.native)
      isShowCenterEmojiPicker.value = false
    }

    const channelAddUsers = async (addUsers) => {
      await CreateChannelUsers(selectChannel.value, addUsers)
      showAddChannelMember.value = false
    }

    const initLoading = async() => {
      // ローディングを表示する
      showLoading.value = true

      // ユーザー取得
      const user = await FindUser()
      userId.value = user.id
      userName.value = user.name

      // チャンネルのユーザー取得
      channelUsers.value = await FetchChannelUsers(selectChannel.value);
      userCount.value = channelUsers.value.length

      // チャンネルに属していないユーザー取得
      notChannelUsers.value = await FetchNotChannelUsers(selectChannel.value);

      // 選択中のチャンネルメッセージ取得
      messages.value = await FetchMessages(selectChannel.value)

      // ローディングを非表示にする
      showLoading.value = false

      nextTick(() => {
        scrollMessageListArea()
      })
    }

    window.Echo.channel("create-message").listen('.MessageEvent', result => {
      messages.value.push(result.message)

      nextTick(() => {
        scrollMessageListArea()
      })
    })

    window.Echo.channel("delete-message").listen('.MessageEvent', result => {
      const messageId = result.messageId

      messages.value = messages.value.filter(function (message) { return message.id != messageId } )
    })

    window.Echo.channel("update-message").listen('.MessageEvent', result => {
      const content = result.message
      const messageId = result.messageId

      messages.value.forEach(message => {
        if (message.id == messageId) {
          message.content = content
        }
      })
    })

    window.Echo.channel("create-channel").listen('.ChannelEvent', result => {
      channelList.value.push(result.channelObject)
    })

    window.Echo.channel("update-channel").listen('.ChannelEvent', result => {
      const channel = result.channelObject

      channelList.value.filter(targetChannel => {
        if (targetChannel.id == channel.id) {
          targetChannel.description = channel.description
        }
      })
    })

    window.Echo.channel("update-reaction").listen('.ReactionEvent', result => {
      const reaction = result.reaction

      messages.value.filter(function (message) {
        // 更新したリアクションのメッセージIDと同じメッセージ
        if (message.id == reaction.message_id) {
          // リアクション一覧を追加または更新する
          let isUpdate = false
          message.reactions.filter(function (targetReaction) {
            if (targetReaction.id == reaction.id) {
              targetReaction.number += 1
              isUpdate = true
            }
          })
          if (isUpdate === false) {
            message.reactions.push(reaction)
          }
        }
      })
    })

    const reactionMessage = (messageId) => {
      isShowCenterEmojiPicker.value = true
      selectMessageId.value = messageId
    }

    onMounted(async () => {
      await initLoading()
    });

    return {
      userId,
      userName,
      email,
      userCount,
      showLoading,
      showAddMember,
      showAddMemberSuccess,
      showAddChannel,
      showAddChannelSuccess,
      showChannelDetail,
      showEditChannelDescription,
      showAddChannelMember,
      sendInvitationMail,
      updateEmail,
      addChannel,
      fetchChannels,
      messages,
      channelList,
      channelName,
      channelDescription,
      channelCreateUser,
      channelUsers,
      channelAddUsers,
      notChannelUsers,
      isChannelTab,
      isChannelPublic,
      isChannelUpdate,
      selectChannel,
      messageListArea,
      reactionMessage,
      changeChannel,
      updateAddChannelName,
      updateAddChannelDescription,
      updateAddChannelIsPrivate,
      updateChannelDescription,
      updateDescription,
      addChannelName,
      addChannelDescription,
      addChannelIsPrivate,
      openMembersModal,
      isShowEmojiPicker,
      isShowCenterEmojiPicker,
      inputEmoji,
      reactionEmoji,
      chatInputArea
    }
  },
}
</script>
<style scoped>
.main {
  display: grid;
  grid-template-columns: minmax(210px, 20%) 1fr;
  grid-auto-rows: 30px calc(100vh - 30px);
  min-height: 100vh;
  margin: 0;
}
.header {
  grid-row: 1;
  grid-column: 1 / span 2;
  background-color:#350d36;
}
.side-menu {
  grid-row: 2;
  grid-column: 1;
  overflow-y: scroll;
  overflow-x: hidden;
  background-color:#3F0E40;
}
.message-area {
  grid-row: 2;
  grid-column: 2;
  overflow-y: hidden;
  overflow-x: hidden;

  display: grid;
  grid-auto-rows: 50px 1fr 100px;
}
@media screen and (max-width: 500px) {
  .main {
    grid-template-columns: 1fr;
  }
  .side-menu {
    display: none;
  }
  .message-area {
    grid-column: 1;
  }
}
.list-enter-active,
.list-leave-active {
  transition: opacity 0.5s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
}
</style>
