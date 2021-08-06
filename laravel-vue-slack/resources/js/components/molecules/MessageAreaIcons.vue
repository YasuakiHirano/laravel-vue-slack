<template>
  <div class="opacity-0 group-hover:opacity-100 bg-white border-2 border-gray-300 shadow-lg rounded-md border flex pt-1 pb-1 justify-end message-tool-area pr-3 pl-3">
    <div class="mr-1 p-1 hover:bg-gray-200 rounded-md">
      <happy-icon @click="reactionMessage" class="h-6 w-6" />
    </div>
    <div class="p-1 hover:bg-gray-200 rounded-md">
      <thread-icon @click="threadMessage" class="h-6 w-6" />
    </div>
    <div class="p-1 hover:bg-gray-200 rounded-md" v-show="isMyMessage">
      <edit-icon @click="editMessage" class="h-6 w-6" />
    </div>
    <div class="p-1 hover:bg-gray-200 rounded-md" v-show="isMyMessage">
      <delete-icon @click="deleteMessage" class="h-6 w-6" />
    </div>
  </div>
</template>

<script>
export default {
  props: ['messageId', 'channelId', 'isMyMessage'],
  setup(props, context) {
    const reactionMessage = async () => {
      context.emit('event:reactionMessage', props.messageId)
    }

    const threadMessage = async () => {
      context.emit('event:threadMessage', props.messageId)
    }

    const deleteMessage = async () => {
      context.emit('event:deleteMessage', props.messageId, props.channelId)
    }

    const editMessage = async () => {
      context.emit('event:editMessage', props.messageId)
    }

    return {
      reactionMessage,
      threadMessage,
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
