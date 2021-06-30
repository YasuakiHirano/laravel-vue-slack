<template>
  <div class="text-right pt-1 pr-2">
    <user-information>{{ userName }}</user-information>
  </div>
</template>
<script>
export default ({
  props: ['userName']
})
</script>
