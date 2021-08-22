<template>
  <transition name="fade">
    <div v-show="isShow" class="rounded-lg absolute top-10 cursor-pointer flex items-center justify-between p-2 w-10/12 bg-red-500 ring-4 ring-red-300 shadow text-white text-sm">
      {{ message }}
      <cancel-icon class="w-6 h-6" @click="$emit('event:errorMessageClose')" />
    </div>
  </transition>
</template>
<script>
export default({
  props:['message', 'isShow']
})
</script>
<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>

