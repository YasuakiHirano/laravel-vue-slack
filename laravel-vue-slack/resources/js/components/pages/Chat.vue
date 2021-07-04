<template>
    <div class="main">
        <loading-display :isShow="showLoading" />
        <chat-header class="header" :userName="userName" />
        <side-menu class="side-menu" @event:AddMember="toggleAddMemberModal" />
        <div class="message-area">
            <show-channel-name># channel name.</show-channel-name>
            <div class="w-full overflow-y-scroll">
                <div class="border mt-5 border-b-0 w-full">
                    <div class="border -mt-3 bg-white p-1 rounded-3xl w-28 m-auto text-xs text-center font-bold">
                        6月9日(水)
                    </div>
                    <div class="p-5 pt-0 flex">
                        <div class="w-12">
                            <img src="image/user_image.png" class="w-11 border rounded-md" />
                        </div>
                        <div class="ml-2">
                            <div class="font-bold text-sm">user name<span class="ml-1 text-xs font-normal text-gray-400">8:00</span></div>
                            test<br/>
                            test<br/>
                            test<br/>
                        </div>
                    </div>
                </div>
                <div class="border mt-5 border-b-0 w-full">
                    <div class="border -mt-3 bg-white p-1 rounded-3xl w-28 m-auto text-xs text-center font-bold">
                        6月10日(木)
                    </div>
                    <div class="p-5 pt-0 flex">
                        <div class="w-12">
                            <img src="image/user_image.png" class="w-11 border rounded-md" />
                        </div>
                        <div class="ml-2">
                            <div class="font-bold text-sm">user name<span class="ml-1 text-xs font-normal text-gray-400">8:00</span></div>
                            test<br/>
                            test<br/>
                            test<br/>
                        </div>
                    </div>
                </div>
                <div class="border mt-5 border-b-0 w-full">
                    <div class="border -mt-3 bg-white p-1 rounded-3xl w-28 m-auto text-xs text-center font-bold">
                        6月11日(金)
                    </div>
                    <div class="p-5 pt-0 flex">
                        <div class="w-12">
                            <img src="image/user_image.png" class="w-11 border rounded-md" />
                        </div>
                        <div class="ml-2">
                            <div class="font-bold text-sm">user name<span class="ml-1 text-xs font-normal text-gray-400">8:00</span></div>
                            test<br/>
                            test<br/>
                            test<br/>
                        </div>
                    </div>
                </div>
                <div class="border mt-5 border-b-0 w-full">
                    <show-date>6月12日(土）</show-date>
                    <div class="group p-5 pt-0 flex hover:bg-gray-100 pt-1 pb-1 mt-1 relative">
                        <message-area-icons />
                        <div class="w-12">
                            <chat-user-image image="image/user_image.png" />
                        </div>
                        <div class="ml-2">
                            <div><chat-user-name>taro</chat-user-name><chat-user-date>08:00</chat-user-date></div>
                            test<br/>
                            test<br/>
                            test<br/>
                            <div class="flex mt-1">
                                <reaction-circle :number="5" icon="😆" class="mr-1" />
                                <reaction-circle :number="10" icon="👍" class="mr-1"  />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border mt-5 border-b-0 w-full">
                    <div class="border -mt-3 bg-white p-1 rounded-3xl w-28 m-auto text-xs text-center font-bold">
                        今日
                    </div>
                    <div class="group p-5 pt-0 flex hover:bg-gray-100 pt-1 pb-1 mt-1 relative">
                        <message-area-icons />
                        <div class="w-12">
                            <img src="image/user_image.png" class="w-11 border rounded-md" />
                        </div>
                        <div class="ml-2">
                            <div class="font-bold text-sm">user name<span class="ml-1 text-xs font-normal text-gray-400">8:00</span></div>
                            test<br/>
                            test<br/>
                            test<br/>
                        </div>
                    </div>
                </div>
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
            <form-text class="mb-2" type="text" v-model="email" name="email" id="email" placeholder="name@example.com" />
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

export default {
  setup() {
    let userName = ref('')
    let email = ref('')
    let showLoading = ref(true)
    let showAddMember = ref(false)
    let showAddMemberSuccess = ref(false)
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

    const sendInvitationMail = async () => {
      showAddMember.value = false
      showLoading.value = true
      console.log('sendInvitationMail')
      await SendInvitationMail()
      showLoading.value = false
      showAddMemberSuccess.value = true
    }

    onMounted(async () => {
      const user = await FindUser()
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
      toggleAddMemberSuccessModal
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
.message-tool-area {
  position: absolute;
  height: 40px;
  top: -15px;
  right: 30px;
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
