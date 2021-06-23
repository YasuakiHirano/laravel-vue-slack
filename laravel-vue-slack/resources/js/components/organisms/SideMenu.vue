<template>
  <div>
      <service-title />
      <thread-menu />
      <mention-reaction-menu />
      <channel-menu class="pl-3" :toggle="toggle" />
      <div v-if="state.toggleChannel">
        <div class="m-auto w-9/12 text-white text-opacity-70 ">
        #&nbsp;&nbsp;general
        </div>
      </div>
  </div>
</template>

<script>
export default {
  props: ['toggle']
}
</script>