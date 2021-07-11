<template>
  <div class="bg-gray-200 border-gray-500 rounded-md border flex pt-1 pb-1 justify-end">
    <mention-border-icon />
    <reaction-border-icon class="ml-3" />
    <send-message-border-icon class="ml-3 mr-3" @click="$emit('event:clickMessageIcon')" />
  </div>
</template>

<script>
export default {
}
</script>
<style scoped>
</style>
