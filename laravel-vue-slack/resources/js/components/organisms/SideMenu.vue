<template>
  <div>
      <service-title />
      <thread-menu />
      <mention-reaction-menu />
      <add-member @click="$emit('event:AddMember')" />
      <channel-menu class="pl-3" @event:ToggleChannel="toggleShowList" />
      <div v-if="isShowList">
        <div class="m-auto w-9/12 text-white text-opacity-70 ">
        #&nbsp;&nbsp;general
        </div>
      </div>
  </div>
</template>

<script>
import { ref } from 'vue';
export default {
  setup() {
    const isShowList = ref(false);

    const toggleShowList = (toggle) => {
      isShowList.value = toggle;
    }

    return {
      isShowList,
      toggleShowList
    }
  },
}
</script>
