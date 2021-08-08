<template>
  <div class="fixed inset-0 w-full h-full bg-black bg-opacity-60 flex items-center justify-center" style="z-index: 99;" v-show="isShow">
    <loading />
  </div>
</template>
<script>
export default({
  props: ['isShow']
})
</script>
