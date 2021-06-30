<template>
  <div class="fixed inset-0 w-full h-full bg-black bg-opacity-60 z-50 flex items-center justify-center" v-show="isShow">
    <loading />
  </div>
</template>
<script>
export default({
  props: ['isShow']
})
</script>
