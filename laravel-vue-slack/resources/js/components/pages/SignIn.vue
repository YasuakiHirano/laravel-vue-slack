<template>
  <div class="w-10/12 m-auto text-center">
    <app-title class="pt-8 pb-8 pr-10" />
    <sign-in-text>Sign in to laravel-vue-slack.</sign-in-text>
    <div class="w-96 m-auto text-left pt-8 pr-3">
      <form-label class="mb-2" forText="email" showText="Email address" />
      <form-text  class="mb-2" type="text" v-model="emailAddress" name="email" id="email" placeholder="name@example.com" :class="{ 'ring-2' : v$.emailAddress.$error,  'ring-red-500' : v$.emailAddress.$error, }" />
      <div v-for="(error, index) in v$.emailAddress.$errors" :key="index" class="text-xs text-red-500 mb-2">
        <div v-if="error.$validator == 'required'">メールアドレスは必須です。</div>
        <div v-if="error.$validator == 'email'">メールアドレスの形式が正しくありません。</div>
        <div v-if="error.$validator == 'maxLength'">メールアドレスは255文字以下で入力してください。</div>
      </div>
      <form-label class="mb-2" forText="password" showText="Password" />
      <form-text type="password" v-model="password" name="password" id="password" placeholder="Your password" :class="{ 'ring-2' : v$.password.$error,  'ring-red-500' : v$.password.$error, }" />
      <div v-for="(error, index) in v$.password.$errors" :key="index" class="text-xs text-red-500 mt-2">
        <div v-if="error.$validator == 'required'">パスワードは必須です。</div>
        <div v-if="error.$validator == 'maxLength'">パスワードは255文字以下で入力してください。</div>
      </div>
      <sign-in-button class="mt-5" @event:SignIn="signIn" />
    </div>
    <error-alert
      :isShow="isErrorAlertShow"
      :message="errorMessage"
      @event:errorMessageClose="isErrorAlertShow = false" />
  </div>
</template>

<script>
import { ref } from 'vue'
import router from '../../router/index.js'
import { UserSignIn } from '../../apis/signIn.api.js'
import { useVuelidate } from '@vuelidate/core'
import { email, required, maxLength } from '@vuelidate/validators'
import { findErrorMessage } from '../../util/ErrorUtil.js'

export default {
  setup() {
    const emailAddress = ref('')
    const password = ref('')
    const errorMessage = ref('')
    const isErrorAlertShow = ref(false)

    /**
     * サインインする
     */
    const signIn = async () => {
      const isFormCorrect = await v$.value.$validate()
      if (!isFormCorrect) return

      try {
        isErrorAlertShow.value = false
        const isSignIn = await UserSignIn(emailAddress.value, password.value)
        if (isSignIn) {
          router.push({ path: 'chat' })
        }
      } catch (error) {
        errorMessage.value = findErrorMessage(error)
        isErrorAlertShow.value = true
      }
    }

    const rules = {
      emailAddress: { required, email, maxLength: maxLength(255) },
      password: { required, maxLength: maxLength(255) }
    }

    const v$ = useVuelidate(rules, { emailAddress, password })

    return {
      signIn,
      emailAddress,
      password,
      v$,
      errorMessage,
      isErrorAlertShow
    }
  }
}
</script>
