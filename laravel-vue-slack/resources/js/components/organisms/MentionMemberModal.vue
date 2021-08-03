<template>
  <app-modal
    :showModal="showModal"
    :showAction="channelUsers.length !== 0"
    :showCancel="true"
    actionText="選択する"
    cancelText="閉じる"
    @event:modalAction="addUser"
  >
    <template v-slot:app-icon>
      <mention-icon class="h-5 w-5" />
    </template>
    <template v-slot:app-title>
      メンションを送るユーザーを選択する
    </template>
    <template v-slot:app-content>
      <div v-if="channelUsers.length === 0" class="p-5 mx-auto text-red-500">
        追加できるユーザーがいません
      </div>
      <div
        v-else
        :class="'w-full flex p-3 border-b-2 border-gray-300 cursor-pointer hover:bg-gray-100 ' + selectUserStatus(channelUser.name)"
        v-for="channelUser in channelUsers"
        :key="channelUser.id"
        @click="clickUser(channelUser.name)">
          <div class="w-12">
            <chat-user-image class="bg-white" :image="channelUser.imagePath" />
          </div>
          <div class="p-3">
            {{ channelUser.name }}
          </div>
      </div>
    </template>
  </app-modal>
</template>
<script>
import { ref } from 'vue'
export default {
  props: ['channelUsers', 'showModal'],
  setup(props, context) {
    const selectUsers = ref([])
    const clickUser = (name) => {
      if (selectUsers.value.indexOf(name) !== -1) {
        let index = selectUsers.value.indexOf(name)
        selectUsers.value.splice(index, 1)
      } else {
        selectUsers.value.push(name)
      }
    }

    const selectUserStatus = (name) => {
      if (selectUsers.value !== null && selectUsers.value !== undefined) {
        if (selectUsers.value.indexOf(name) !== -1) {
          return 'bg-blue-300'
        }
      }
      return ''
    }

    const addUser = () => {
      context.emit('event:mentionUsers', selectUsers.value)
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
