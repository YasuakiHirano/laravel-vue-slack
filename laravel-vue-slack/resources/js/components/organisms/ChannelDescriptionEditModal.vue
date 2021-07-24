<template>
  <app-modal
    :showModal="showModal"
    :showAction="true"
    :showCancel="true"
    actionText="更新する"
    cancelText="閉じる"
  >
    <template v-slot:app-icon>
      <speaker-icon class="h-5 w-5" />
    </template>
    <template v-slot:app-title>
      説明を編集する
    </template>
    <template v-slot:app-content>
        <textarea
         class="resize-none w-full h-32 border border-gray-800 rounded-md p-3"
         v-model="description"
         @change="updateDescription"
         placeholder="チャンネルの説明を追加"
        ></textarea>
        <div class="text-sm">このチャンネルの目的を入力できます。</div>
    </template>
  </app-modal>
</template>
<script>
import { ref } from 'vue'
export default {
  props: ['showModal', 'description'],
  setup(props, context) {
    const updateDescription = () => {
      context.emit('event:updateDescription', props.description)
    }

    return {
      updateDescription
    }
  }
}
</script>
