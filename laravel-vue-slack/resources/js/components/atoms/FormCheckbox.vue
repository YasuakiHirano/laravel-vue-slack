<template>
    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" class="form-checkbox h-4 w-4" v-model="check" @change="updateCheck" value="true">
            <span class="ml-2 text-sm">{{ label }}</span>
        </label>
    </div>
</template>
<script>
import { ref } from 'vue'

export default {
  props: ['label'],
  setup(props, context) {
    const check = ref(false)

    const updateCheck = () => {
      context.emit('event:updateCheck', check.value)
    }

    return {
      check,
      updateCheck
    }
  }
}
</script>
