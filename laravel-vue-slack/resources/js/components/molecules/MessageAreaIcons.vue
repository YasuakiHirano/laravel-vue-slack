<template>
  <div class="opacity-0 group-hover:opacity-100 bg-white border-2 border-gray-300 shadow-lg rounded-md border flex pt-1 pb-1 justify-end message-tool-area pr-3 pl-3">
    <div class="mr-1 p-1 hover:bg-gray-200 rounded-md">
      <happy-icon class="h-6 w-6" />
    </div>
    <div class="p-1 hover:bg-gray-200 rounded-md">
      <thread-icon class="h-6 w-6" />
    </div>
    <div class="p-1 hover:bg-gray-200 rounded-md">
      <edit-icon @click="editMessage" class="h-6 w-6" />
    </div>
    <div class="p-1 hover:bg-gray-200 rounded-md">
      <delete-icon @click="deleteMessage" class="h-6 w-6" />
    </div>
  </div>
</template>

<script>
import { DeleteMessage } from '../../apis/message.api'
export default {
  props: ['messageId'],
  setup(props, context) {
    const deleteMessage = async () => {
      let deleted = await DeleteMessage(props.messageId)
      if (deleted) {
        context.emit('event:deleteMessage', props.messageId)
      }
    }

    const editMessage = async () => {
      context.emit('event:editMessage', props.messageId)
    }

    return {
      deleteMessage,
      editMessage
    }
  }
}
</script>
<style scoped>
.message-tool-area {
  position: absolute;
  height: 40px;
  top: -15px;
  right: 30px;
}
</style>
