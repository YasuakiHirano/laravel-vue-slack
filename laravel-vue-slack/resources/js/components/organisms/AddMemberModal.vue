<template>
  <app-modal
    :showModal="showModal"
    :showAction="true"
    :showCancel="true"
    actionText="送信"
    cancelText="キャンセル"
  >
    <template v-slot:app-icon>
      <user-icon class="h-5 w-5" />
    </template>
    <template v-slot:app-title> メンバーを招待します </template>
    <template v-slot:app-content>
      <form-text
        ref="emailAddress"
        v-model="checkEmailAddress"
        class="mb-2"
        :class="{ 'ring-2' : v$.checkEmailAddress.$error, 'ring-red-500' : v$.checkEmailAddress.$error }"
        type="text"
        @event:updateText="updateText"
        name="email"
        id="email"
        placeholder="name@example.com"
      />
      <div v-for="(error, index) in v$.checkEmailAddress.$errors" :key="index" class="text-xs text-red-500 mb-2">
        <div v-if="error.$validator == 'required'">メールアドレスは必須です。</div>
        <div v-if="error.$validator == 'email'">メールアドレスの形式が正しくありません。</div>
        <div v-if="error.$validator == 'maxLength'">メールアドレスは255文字以下で入力してください。</div>
      </div>
    </template>
  </app-modal>
</template>
<script>
import { ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { email, required, maxLength } from '@vuelidate/validators'
export default {
  props: ["showModal"],
  setup(props, context) {
    const emailAddress = ref(null)
    const checkEmailAddress = ref('')

    /**
     * メールアドレスを更新するためにemitする
     * @param {string} text　メールアドレスのテキスト
     */
    const updateText = (text) => {
      context.emit("event:updateText", text);
    }

    /**
     * モーダルの入力値バリデーションを行う
     * @return {boolean} true(error)/false(no error)
     */
    const modalValidateError = async () => {
      const isFormCorrect = await v$.value.$validate()
      return !isFormCorrect
    }

    const rules = {
      checkEmailAddress: { email, required, maxLength: maxLength(255) },
    }

    const v$ = useVuelidate(rules, { checkEmailAddress })

    return {
      updateText,
      emailAddress,
      checkEmailAddress,
      modalValidateError,
      v$
    }
  },
}
</script>
