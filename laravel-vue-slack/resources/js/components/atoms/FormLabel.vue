<template>
   <div>
    <label :for="forText">{{ showText }}</label>
  </div> 
</template>
<script>
export default {
  props: ['forText', 'showText']
}
</script>
