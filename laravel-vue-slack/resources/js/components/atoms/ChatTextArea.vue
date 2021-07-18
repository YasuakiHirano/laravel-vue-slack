<template>
  <textarea
    class="resize-none border border-gray-800 rounded-md input-text p-3"
    v-model="text"
    :placeholder="channelName != undefined ? channelName + ' へのメッセージ' : ''"
  ></textarea>
</template>

<script>
import { ref } from 'vue'
export default {
  props:['channelName', 'content'],
  setup(props) {
    const text = ref('')
    text.value = props.content

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
