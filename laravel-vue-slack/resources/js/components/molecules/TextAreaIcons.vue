<template>
  <div class="bg-gray-200 border-gray-500 rounded-md border flex pt-1 pb-1 justify-end">
    <cancel-border-icon v-if="isCancel" @click="$emit('event:clickCancelIcon')" class="ml-3" />
    <mention-border-icon class="ml-3" />
    <reaction-border-icon class="ml-3" @click="$emit('event:clickReactionBorderIcon')" />
    <send-message-border-icon class="ml-3 mr-3" @click="$emit('event:clickMessageIcon')" />
  </div>
</template>

<script>
export default {
  props: ['isCancel']
}
</script>
<style scoped>
</style>
