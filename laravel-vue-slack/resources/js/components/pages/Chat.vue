<template>
    <div class="main">
        <loading-display :isShow="showLoading" />
        <chat-header class="header" :userName="userName" />
        <side-menu class="side-menu" @event:AddMember="toggleAddMemberModal" />
        <div class="message-area">
          <show-channel-name># channel name.</show-channel-name>
          <div class="w-full overflow-y-scroll">
            <span v-for="message in messages" :key="message.id">
                <chat-message
                class="mt-5 w-full"
                :date="message.date"
                :imagePath="message.imagePath"
                :postUserName="message.postUserName"
                :postTime="message.postTime"
                :mentions="message.mentions"
                :content="message.content" />
            </span>
          </div>
          <chat-input-area />
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
import { reactive, onMounted, ref } from 'vue'
import { FindUser } from '../../apis/user.api.js'
import { SendInvitationMail } from '../../apis/mail.api.js'
import { FetchMessages } from '../../apis/message.api.js'

export default {
  setup() {
    let userName = ref('')
    let email = ref('')
    let selectChannel = ref(1)
    let messages = ref([])
    let showLoading = ref(true)
    let showAddMember = ref(false)
    let showAddMemberSuccess = ref(false)

    messages.value = [
      {
        id: 1,
        date: '6月12日(土)',
        imagePath: 'image/user_image.png',
        postUserName: 'taro',
        postTime: '08:00',
        content: "test<br>hoge<br>test",
        mentions: [{
          id: 1,
          number: 10,
          icon: '😵'
        },{
          id: 2,
          number: 13,
          icon: '😇'
        },]
      },
      {
        id: 2,
        date: '6月13日(日)',
        imagePath: 'image/user_image.png',
        postUserName: 'taro',
        postTime: '08:00',
        content: "test<br>hoge<br>test",
        mentions: null
      },
      {
        id: 3,
        date: '今日',
        imagePath: 'image/user_image.png',
        postUserName: 'taro',
        postTime: '08:00',
        content: "test<br>hoge<br>test",
        mentions: [{
          id: 1,
          number: 7,
          icon: '👍🏻'
        }]
      }
    ]

    const state = reactive({
      toggleChannel: false
    });

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
      console.log('sendInvitationMail', email.value)
      await SendInvitationMail(email.value)
      showLoading.value = false
      showAddMemberSuccess.value = true
    }

    onMounted(async () => {
      const user = await FindUser()
      messages.value = await FetchMessages(selectChannel.value)
      userName.value = user.name
      showLoading.value = false
    });

    return {
      state,
      userName,
      email,
      showLoading,
      showAddMember,
      showAddMemberSuccess,
      sendInvitationMail,
      toggleAddMemberModal,
      toggleAddMemberSuccessModal,
      updateEmail,
      messages,
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
</style>
