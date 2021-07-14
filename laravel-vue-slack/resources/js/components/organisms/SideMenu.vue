<template>
  <div>
      <service-title />
      <thread-menu />
      <mention-reaction-menu />
      <add-member @click="$emit('event:AddMember')" />
      <channel-menu class="pl-3" @event:ToggleChannel="toggleShowList" />
      <div v-if="isShowList">
        <div v-for="channel in channels" :key="channel.name" class="m-auto w-9/12 text-white text-opacity-70">
          #&nbsp;&nbsp;{{ channel.name }}
        </div>
      </div>
  </div>
</template>

<script>
import { ref, onMounted, reactive } from 'vue'
import { FetchChannel } from '../../apis/channel.api.js'
export default {
  setup(props, context) {
    const channels = ref([])
    const isShowList = ref(false)

    const toggleShowList = (toggle) => {
      isShowList.value = toggle
    }

    onMounted(async () => {
      const responseChannels = await FetchChannel()
      channels.value = responseChannels
      context.emit('event:FetchChannels', responseChannels)
    });

    return {
      isShowList,
      toggleShowList,
      channels
    }
  },
}
</script>
