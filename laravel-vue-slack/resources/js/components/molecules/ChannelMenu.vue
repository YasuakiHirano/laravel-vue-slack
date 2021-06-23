<template>
  <div class="text-sm text-white text-opacity-70 cursor-pointer flex justify-between">
    <div class="flex">
      <template v-if="toggle">
        <arrow-bottom-icon class="h-5 w-5 mr-1" />
      </template>
      <template v-else>
        <arrow-right-icon class="h-5 w-5 mr-1" />
      </template>
      チャンネル
    </div>
    <div class="mr-5 opacity-60 hover:opacity-100">
      <plus-icon />
    </div>
  </div>
</template>

<script>
export default {
  props: ['toggle']
}
</script>