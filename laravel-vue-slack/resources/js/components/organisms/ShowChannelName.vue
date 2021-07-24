<template>
  <div class="border text-lg font-bold flex justify-between">
      <div class="pt-2 pl-5 cursor-pointer" @click="$emit('event:openChannelDetail')">
        <slot />
      </div>
      <user-entry-count class="mr-4 mt-2 mb-2" @click="$emit('event:clickCountChannel')">{{ count }}</user-entry-count>
  </div>
</template>
<script>
import { ref, onMounted } from 'vue'
import { CountChannelUsers } from '../../apis/channel.api.js'

export default {
  props:['channelId'],
  setup(props) {
    const count = ref(0)

    onMounted(async () => {
      count.value = await CountChannelUsers(props.channelId)
    });

    return {
      count
    }
  }
}
</script>
