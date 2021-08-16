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
         placeholder="チャンネルの説明を追加"
        ></textarea>
        <div v-for="(error, index) in v$.description.$errors" :key="index" class="text-xs text-red-500 mb-2">
          <div v-if="error.$validator == 'required'">チャンネルの説明は必須です。</div>
          <div v-if="error.$validator == 'maxLength'">チャンネルの説明は1024文字以下で入力してください。</div>
        </div>
        <div class="text-sm">このチャンネルの目的を入力できます。</div>
    </template>
  </app-modal>
</template>
<script>
import { ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, maxLength } from '@vuelidate/validators'

export default {
  props: ['showModal', 'propDescription'],
  setup(props, context) {
    const description = ref('')

    /**
     * モーダルの入力値バリデーションを行う
     * @return {boolean} true(error)/false(no error)
     */
    const modalValidateError = async () => {
      const isFormCorrect = await v$.value.$validate()
      return !isFormCorrect
    }

    const rules = {
      description: { required, maxLength: maxLength(1024) }
    }

    const v$ = useVuelidate(rules, { description })

    return {
      description,
      modalValidateError,
      v$
    }
  }
}
</script>
