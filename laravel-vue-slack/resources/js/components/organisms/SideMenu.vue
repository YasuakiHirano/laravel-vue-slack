<template>
  <div>
      <service-title />
      <thread-menu />
      <mention-reaction-menu />
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
            {{ channel.name }}
          </div>
        </div>
      </div>
  </div>
</template>

<script>
import { ref, onMounted, reactive } from 'vue'
import { FetchChannel } from '../../apis/channel.api.js'
export default {
  props: ['channelId'],
  setup(props, context) {
    const channels = ref([])
    const isShowList = ref(false)

    const toggleShowList = (toggle) => {
      isShowList.value = toggle
    }

    const selectChannel = (channelId) => {
      context.emit('event:SelectChannel', channelId)
    }

    onMounted(async () => {
      const responseChannels = await FetchChannel()
      channels.value = responseChannels
      context.emit('event:FetchChannels', responseChannels)
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
