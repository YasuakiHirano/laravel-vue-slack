<template>
  <app-modal
    :showModal="showModal"
    :showAction="true"
    :showCancel="false"
    actionText="閉じる"
  >
    <template v-slot:app-icon>
      <speaker-icon class="h-5 w-5" />
    </template>
    <template v-slot:app-title>
      <div class="flex">
        <div v-if="isChannelPublic"><hash-icon class="mt-1 w-5 h-5"></hash-icon></div>
        <div v-else><lock-icon class="mt-1 w-5 h-5"></lock-icon></div>
        <div class="mr-1">{{ channelName }}</div>
      </div>
    </template>
    <template v-slot:app-content>
      <div class="bg-white">
        <nav class="flex">
          <button :class="channelTabClass" @click="isChannelTab = true;selectChannel(isChannelTab)">
            チャンネル情報
          </button>
          <button :class="memberTabClass" @click="isChannelTab = false;selectChannel(isChannelTab)">
            メンバー
          </button>
        </nav>
        <div class="flex mt-2" v-if="isChannelTab">
          <div class="w-full rounded shadow ring-2 ring-blue-400">
            <div class="relative group p-3 border-b-2 border-blue-400 hover:bg-blue-200 cursor-pointer whitespace-pre-wrap break-all" @click="$emit('event:editChannelDescription')">
              <div class="opacity-0 group-hover:opacity-100 font-bold absolute text-xs text-blue-800 top-3 right-3">編集</div>
              <div class="text-sm font-semibold">説明</div>
              {{ description }}
            </div>
            <div class="p-3 hover:bg-blue-200">
              <div class="text-sm font-semibold">作成者</div>
              {{ createUser }}
            </div>
          </div>
        </div>
        <div class="mt-2" v-else>
          <form-action-button class="mt-2 mb-3" @click="$emit('event:addChannelMember')">
            <happy-icon class="w-5 h-5 mr-2" />チャンネルにメンバーを追加する
          </form-action-button>
          <div class="w-full flex p-3 border-b-2 border-gray-300" v-for="channelUser in channelUsers" :key="channelUser.id">
              <div class="w-12">
                <chat-user-image :image="channelUser.imagePath" />
              </div>
              <div class="p-3">
                {{ channelUser.name }}
              </div>
          </div>
        </div>
      </div>
    </template>
  </app-modal>
</template>
<script>
import { ref } from 'vue'
export default {
  props: ['showModal', 'isChannelTab', 'channelName', 'channelUsers', 'description', 'createUser', 'isChannelPublic'],
  setup(props, context) {
    const channelTabClass = ref('')
    const memberTabClass = ref('')

    const selectChannel = (isChannelTab) => {
      if (isChannelTab) {
        memberTabClass.value = 'text-gray-600 py-4 w-1/2 block hover:text-blue-500 focus:outline-none'
        channelTabClass.value = 'text-gray-600 py-4 w-1/2 block hover:text-blue-500 focus:outline-none text-blue-500 border-b-2 font-medium border-blue-500'
      } else {
        memberTabClass.value = 'text-gray-600 py-4 w-1/2 block hover:text-blue-500 focus:outline-none text-blue-500 border-b-2 font-medium border-blue-500'
        channelTabClass.value = 'text-gray-600 py-4 w-1/2 block hover:text-blue-500 focus:outline-none'
      }

      context.emit('event:isChannelUpdate', isChannelTab)
    }

    selectChannel(props.isChannelTab)

    return {
      channelTabClass,
      memberTabClass,
      selectChannel
    }
  },
  watch: {
    isChannelTab: 'selectChannel'
  }
}
</script>
