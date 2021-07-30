<template>
  <div class="bg-blue-200 text-center pl-1 pr-1 rounded-full border-blue-700 text-base border-2">
      <reaction-icon>{{ icon }}</reaction-icon><reaction-number class="ml-1 mr-1">{{ number }}</reaction-number>
  </div>
</template>

<script>
export default {
  props: ['icon', 'number']
}
</script>
<style scoped>
</style>
