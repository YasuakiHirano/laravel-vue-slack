<template>
  <app-modal
    :showModal="showModal"
    :showAction="notChannelUsers.length !== 0"
    :showCancel="true"
    actionText="追加する"
    cancelText="閉じる"
    @event:modalAction="addUser"
  >
    <template v-slot:app-icon>
      <user-icon class="h-5 w-5" />
    </template>
    <template v-slot:app-title>
      チャンネルにメンバーを追加する
    </template>
    <template v-slot:app-content>
      <div v-if="notChannelUsers.length === 0" class="p-5 mx-auto text-red-500">
        追加できるユーザーがいません
      </div>
      <div
        v-else
        :class="'w-full flex p-3 border-b-2 border-gray-300 cursor-pointer hover:bg-gray-100 ' + selectUserStatus(notChannelUser.id)"
        v-for="notChannelUser in notChannelUsers"
        :key="notChannelUser.id"
        @click="clickUser(notChannelUser.id)">
          <div class="w-12">
            <chat-user-image class="bg-white" :image="notChannelUser.imagePath" />
          </div>
          <div class="p-3">
            {{ notChannelUser.name }}
          </div>
      </div>
    </template>
  </app-modal>
</template>
<script>
import { ref } from 'vue'
export default {
  props: ['notChannelUsers', 'showModal'],
  setup(props, context) {
    const selectUsers = ref([])
    const clickUser = (id) => {
      if (selectUsers.value.indexOf(id) !== -1) {
        let index = selectUsers.value.indexOf(id)
        selectUsers.value.splice(index, 1)
      } else {
        selectUsers.value.push(id)
      }
    }

    const selectUserStatus = (id) => {
      if (selectUsers.value !== null && selectUsers.value !== undefined) {
        if (selectUsers.value.indexOf(id) !== -1) {
          return 'bg-blue-300'
        }
      }
      return ''
    }

    const addUser = () => {
      context.emit('event:addUsers', selectUsers.value)
    }

    return {
      selectUsers,
      clickUser,
      selectUserStatus,
      addUser
    }
  }
}
</script>
