<template>
  <button
    class="w-full rounded-md bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50 text-2xl text-white pt-1 pb-1"
    @click="$emit('event:AccountCreate')"
    :disabled="disabled"
  >Create Account</button>
</template>
<script>
export default {
  props:['disabled']
}
</script>
