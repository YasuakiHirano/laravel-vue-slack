<template>
  <div class="text-sm text-white text-opacity-70 cursor-pointer flex justify-between">
    <div class="flex" @click="toggleChannels();$emit('event:ToggleChannel', state.toggleChannel);">
      <template v-if="state.toggleChannel">
        <arrow-bottom-icon class="h-5 w-5 mr-1" />
      </template>
      <template v-else>
        <arrow-right-icon class="h-5 w-5 mr-1" />
      </template>
      チャンネル
    </div>
    <div class="mr-5 opacity-60 hover:opacity-100" @click="$emit('event:AddChannel')">
      <plus-icon />
    </div>
  </div>
</template>

<script>
import { reactive } from 'vue';
export default {
  props: ['toggle'],
  setup() {
    const state = reactive({
      toggleChannel: false
    });

    const toggleChannels = () => {
      if (state.toggleChannel) {
        state.toggleChannel = false;
      } else {
        state.toggleChannel = true;
      }
    }

    return {
      toggleChannels,
      state
    }
  },
}
</script>