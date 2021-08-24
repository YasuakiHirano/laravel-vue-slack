<template>
  <div>
      <service-title />
      <add-member @click="$emit('event:AddMember')" />
      <channel-menu
        class="pl-3"
        @event:ToggleChannel="toggleShowList"
        @event:AddChannel="$emit('event:AddChannel')" />
      <div v-if="isShowList">
        <div v-for="channel in channels" :key="channel.name" class="m-auto w-9/12 text-white text-opacity-70">
          <div :class="'w-full flex p-1 cursor-pointer ' + (channel.id === channelId ? 'bg-indigo-900 rounded-lg' : '')" @click="selectChannel(channel.id)">
            <div v-if="channel.is_public"><hash-icon class="mt-1 mr-2 w-4 h-4" /></div>
            <div v-else><lock-icon class="mt-1 mr-2 w-4 h-4" /></div>
            <div class="w-13 truncate">{{ channel.name }}</div>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
import router from '../../router/index.js'
import { ref, onMounted } from 'vue'
import { FetchChannel } from '../../apis/channel.api.js'
export default {
  props: ['channelId'],
  setup(props, context) {
    const channels = ref([])
    const isShowList = ref(false)

    /**
     * チャンネル一覧の表示/非表示切り替え
     * @param {boolean} toggle
     */
    const toggleShowList = (toggle) => {
      isShowList.value = toggle
    }

    /**
     * チャンネルを選択したときにemitする
     * @param {boolean} channelId 選択したチャンネルのID
     */
    const selectChannel = (channelId) => {
      context.emit('event:SelectChannel', channelId)
    }

    onMounted(async () => {
      try {
        const responseChannels = await FetchChannel()
        channels.value = responseChannels
        context.emit('event:FetchChannels', responseChannels)
      } catch (error) {
        if (error.response.status === 401) {
          router.push({ path: '/' })
        }
      }
    });

    return {
      isShowList,
      toggleShowList,
      channels,
      selectChannel
    }
  },
}
</script>
