<template>
  <div class="w-10/12 m-auto text-center">
    <app-title class="pt-8 pb-8 pr-10" />
    <sign-in-text>Join laravel-vue-slack.</sign-in-text>
    <div class="w-96 m-auto text-left pt-8 pr-3">
      <div>Email address</div>
      <div class="mb-5">{{ sendEmail }}</div>
      <form-label class="mb-2" forText="name" showText="User Name" />
      <form-text  class="mb-2" type="text" v-model="inputName" name="user_name" id="user_name" placeholder="User name" :class="{ 'ring-2' : v$.inputName.$error, 'ring-red-500' : v$.inputName.$error }" />
      <div v-for="(error, index) in v$.inputName.$errors" :key="index" class="text-xs text-red-500 mb-2">
        <div v-if="error.$validator == 'required'">ユーザー名は必須です。</div>
        <div v-if="error.$validator == 'maxLength'">ユーザー名は25文字以下で入力してください。</div>
      </div>
      <form-label class="mb-2" forText="password" showText="Password" />
      <form-text  class="mb-2" type="password" v-model="inputPassword" name="password" id="password" placeholder="Your password" :class="{ 'ring-2' : v$.inputPassword.$error, 'ring-red-500' : v$.inputPassword.$error }" />
      <div v-for="(error, index) in v$.inputPassword.$errors" :key="index" class="text-xs text-red-500 mb-2">
        <div v-if="error.$validator == 'required'">パスワードは必須です。</div>
        <div v-if="error.$validator == 'maxLength'">パスワードは50文字以下で入力してください。</div>
      </div>
      <account-create-button class="mt-5" @event:AccountCreate="accountCreate" :disabled="isDisableCreateButton" />
    </div>
    <error-alert
      :isShow="isErrorAlertShow"
      :message="errorMessage"
      @event:errorMessageClose="isErrorAlertShow = false" />
  </div>
</template>

<script>
import { ref } from 'vue'
import { CreateUser } from '../../apis/user.api.js'
import { useVuelidate } from '@vuelidate/core'
import { required, maxLength } from '@vuelidate/validators'
import { findErrorMessage } from '../../util/ErrorUtil.js'

export default {
  props: ['sendEmail'],
  setup(props) {
    const inputName = ref('')
    const inputPassword = ref('')
    const errorMessage = ref('')
    const isErrorAlertShow = ref(false)
    const isDisableCreateButton = ref(false)

    /**
     * 入力値からアカウントを作成する
     */
    const accountCreate = async () => {
      const isFormCorrect = await v$.value.$validate()
      if (!isFormCorrect) return

      try {
        isDisableCreateButton.value = true
        isErrorAlertShow.value = false
        const created = await CreateUser(props.sendEmail, inputName.value, inputPassword.value)
        if (created) {
          location.href = location.protocol + "//" +location.host + "/#/chat"
        }
      } catch (error) {
        errorMessage.value = findErrorMessage(error)
        isErrorAlertShow.value = true
      }

      isDisableCreateButton.value = false
    }

    const rules = {
      inputName: { required, maxLength: maxLength(25) },
      inputPassword: { required, maxLength: maxLength(50)  }
    }

    const v$ = useVuelidate(rules, { inputName, inputPassword })

    return {
      accountCreate,
      inputName,
      inputPassword,
      isDisableCreateButton,
      v$,
      errorMessage,
      isErrorAlertShow,
    }
  }
}
</script>
<style scoped>
</style>
