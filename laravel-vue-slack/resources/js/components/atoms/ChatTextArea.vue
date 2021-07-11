<template>
  <textarea class="resize-none border border-gray-800 rounded-md input-text p-3 h-4/5 mt-2" v-model="text" placeholder="#channel nameへのメッセージ"></textarea>
</template>

<script>
import { ref } from 'vue'
export default {
  props:['channelName'],
  setup() {
    const text = ref('')

    return {
      text
    }
  }
}
</script>
<style scoped>
.input-text {
  width: 98%;
}
</style>
