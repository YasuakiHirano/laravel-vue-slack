<template>
  <div v-show="isShow">
      <Picker :data="emojiIndex" set="twitter" @select="selectEmoji" />
  </div>
</template>
<script>
import data from 'emoji-mart-vue-fast/data/all.json'
import 'emoji-mart-vue-fast/css/emoji-mart.css'
import { Picker, EmojiIndex } from 'emoji-mart-vue-fast/src'
import { ref } from 'vue'

export default({
  props: ['isShow'],
  components: {
    Picker
  },
  setup(props, content) {
    let emojiIndex = new EmojiIndex(data)
    let emojisOutput = ''

    const selectEmoji = (emoji) => {
      content.emit('event:selectEmoji', emoji)
    }

    return {
      emojiIndex,
      emojisOutput,
      selectEmoji,
    }
  },
})
</script>

