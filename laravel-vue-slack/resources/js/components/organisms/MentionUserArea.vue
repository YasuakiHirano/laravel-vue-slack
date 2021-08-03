<template>
  <div class="bg-black opacity-80 rounded absolute left-3 -top-7 flex" v-show="mentionUsers.length !== 0">
    <arrow-right-icon class="w-5 h-5 bg-white opacity-100 m-3 rounded" v-show="isArrowRight" @click="toggleArrow" />
    <arrow-left-icon class="w-5 h-5 bg-white opacity-100 m-3 rounded" v-show="!isArrowRight" @click="toggleArrow" />
    <div class="flex" v-for="(mentionUser, index) in mentionUsers" :key="index" v-show="isArrowRight">
      <div class="bg-blue-400 text-sm m-2 mr-1 p-1 rounded flex"><div>@{{ mentionUser }}</div><cancel-icon class="ml-1 h-5 w-5 cursor-pointer" @click="deleteMentionUser(mentionUser)" /></div>
    </div>
  </div>
</template>
<script>
import { ref } from 'vue'
export default ({
  setup(props, context) {
    const isArrowRight = ref(true)
    const mentionUsers = ref([])
    const deleteMentionUser = (mentionUser) => {
      context.emit('evnet:deleteMentionUser', mentionUser)
    }

    const toggleArrow = () => {
      if (isArrowRight.value) {
        isArrowRight.value = false
      } else {
        isArrowRight.value = true
      }
    }

    return {
      mentionUsers,
      deleteMentionUser,
      isArrowRight,
      toggleArrow
    }
  },
})
</script>

