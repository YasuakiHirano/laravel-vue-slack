<template>
    <div class="main">
        <loading-display :isShow="showLoading" />
        <chat-header class="header" :userName="userName" />
        <side-menu class="side-menu" @event:AddMember="toggleAddMemberModal" @event:FetchChannels="fetchChannels" />
        <div class="message-area">
          <show-channel-name :channelId="selectChannel">
              <div class="flex">
                <div v-if="isChannelPublic"><hash-icon class="mt-1 w-5 h-5"></hash-icon></div>
                <div v-else><lock-icon class="mt-1 w-5 h-5"></lock-icon></div>
                <div class="mr-1">{{ channelName }}</div>
              </div>
          </show-channel-name>
          <div class="w-full overflow-y-scroll" ref="messageListArea">
            <span v-for="message in messages" :key="message.id">
                <transition-group name="message" tag="div">
                  <chat-message
                  class="mt-5 w-full"
                  :messageId="message.id"
                  :date="message.date"
                  :imagePath="message.imagePath"
                  :postUserName="message.postUserName"
                  :postTime="message.postTime"
                  :mentions="message.mentions"
                  :content="message.content"
                  @event:deleteMessage="deleteMessage" />
                </transition-group>
            </span>
          </div>
          <chat-input-area :channelName="channelName" />
        </div>
        <app-modal
          :showModal="showAddMember"
          :showAction="true"
          :showCancel="true"
          actionText="送信"
          cancelText="キャンセル"
          @event:modalClose="toggleAddMemberModal"
          @event:modalAction="sendInvitationMail"
          >
          <template v-slot:app-icon>
            <user-icon class="h-5 w-5" />
          </template>
          <template v-slot:app-title>
            メンバーを招待します
          </template>
          <template v-slot:app-content>
            <form-text class="mb-2" type="text" @event:updateText="updateEmail" name="email" id="email" placeholder="name@example.com" />
          </template>
        </app-modal>
        <app-modal
          :showModal="showAddMemberSuccess"
          :showAction="true"
          :showCancel="false"
          actionText="終了"
          @event:modalAction="toggleAddMemberSuccessModal">
          <template v-slot:app-icon>
            <user-icon class="h-5 w-5" />
          </template>
          <template v-slot:app-title>
            送信済み
          </template>
          <template v-slot:app-content>
            メンバーの招待が完了しました！
          </template>
        </app-modal>
    </div>
</template>

<script>
import { onMounted, ref, nextTick } from 'vue'
import { FindUser } from '../../apis/user.api.js'
import { SendInvitationMail } from '../../apis/mail.api.js'
import { FetchMessages } from '../../apis/message.api.js'

export default {
  setup() {
    const userName = ref('')
    const email = ref('')
    const channelName = ref('')
    const isChannelPublic = ref(false)
    const selectChannel = ref(1)
    const messages = ref([])
    const showLoading = ref(true)
    const showAddMember = ref(false)
    const showAddMemberSuccess = ref(false)
    const messageListArea = ref(null)

    const toggleAddMemberModal = () => {
      if (showAddMember.value) {
        showAddMember.value = false
      } else {
        showAddMember.value = true
      }
    }

    const toggleAddMemberSuccessModal = () => {
      if (showAddMemberSuccess.value) {
        showAddMemberSuccess.value = false
      } else {
        showAddMemberSuccess.value = true
      }
    }

    const updateEmail = (text) => {
      email.value = text.value
    }

    const sendInvitationMail = async () => {
      showAddMember.value = false
      showLoading.value = true
      await SendInvitationMail(email.value)
      showLoading.value = false
      showAddMemberSuccess.value = true
    }

    const scrollMessageListArea = () => {
      messageListArea.value.scrollTop = messageListArea.value.scrollHeight;
    }

    const fetchChannels = (channels) => {
      // チャンネル情報から現在のチャンネル名取得
      const channel = channels.find(channel => channel.id === selectChannel.value)

      channelName.value = channel.name
      isChannelPublic.value = channel.is_public ? true : false
    }

    const deleteMessage = (messageId) => {
      messages.value = messages.value.filter(function (value) { return value.id != messageId } )
    }

    onMounted(async () => {
      // ユーザー取得
      const user = await FindUser()
      userName.value = user.name

      // 選択中のチャンネルメッセージ取得
      messages.value = await FetchMessages(selectChannel.value)

      // ダイアログを非表示
      showLoading.value = false
      window.Echo.channel(channelName.value + "-create-message").listen('.MessageEvent', result => {
        messages.value.push(result.message)

        nextTick(() => {
          scrollMessageListArea()
        })
      });

      window.Echo.channel(channelName.value + "-delete-message").listen('.MessageEvent', result => {
        deleteMessage(result.message)
      });

      nextTick(() => {
        scrollMessageListArea()
      })
    });

    return {
      userName,
      email,
      showLoading,
      showAddMember,
      showAddMemberSuccess,
      sendInvitationMail,
      toggleAddMemberModal,
      toggleAddMemberSuccessModal,
      updateEmail,
      fetchChannels,
      messages,
      channelName,
      isChannelPublic,
      selectChannel,
      messageListArea,
      deleteMessage
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

.v-enter-active, .v-leave-active {
  transition: opacity 1s;
}
.v-enter, .v-leave-to {
  opacity: 0;
}
</style>
