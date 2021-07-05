<template>
  <input :type="type" :name="name" :id="id" :placeholder="placeholder" v-model="text" @change="updateText" class="w-full p-2 rounded-md border border-gray-500 shadow-sm focus:ring-4 focus:ring-blue-300" />
</template>
<script>
import { ref } from 'vue'
export default {
  props: ['type', 'name', 'id', 'placeholder'],
  setup(props, context) {
    let text = ref('')
    const updateText = () => {
      context.emit('event:updateText', text)
    }

    return {
      text,
      updateText
    }
  }
}
</script>
