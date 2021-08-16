<template>
  <button
    class="border border-green-800 rounded p-1 cursor-pointer"
    :class="{'bg-gray-500': isDisable, 'hover:bg-gray-600': isDisable, 'bg-green-400': !isDisable, 'hover:bg-green-600': !isDisable}"
    :disabled="isDisable"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
    </svg>
  </button>
</template>

<script>
export default {
  props: ['isDisable']
}
</script>
<style scoped>
</style>
