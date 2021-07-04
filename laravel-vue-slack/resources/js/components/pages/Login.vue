<template>
  <div class="w-10/12 m-auto text-center">
    <app-title class="pt-8 pb-8 pr-10" />
    <sign-in-text>Sign in to laravel-vue-slack.</sign-in-text>
    <div class="w-96 m-auto text-left pt-8">
      <form-label class="mb-2" forText="email" showText="Email address" />
      <form-text  class="mb-2" type="text" v-model="email" name="email" id="email" placeholder="name@example.com" />
      <form-label class="mb-2" forText="password" showText="Password" />
      <form-text  class="mb-5" type="password" v-model="password" name="password" id="password" placeholder="Your password" />
      <sign-in-button @event:SignIn="signIn" />
    </div>
  </div>
</template>

<script>
import router from '../../router/index.js'
import { UserSignIn, FetchUsers } from '../../apis/signIn.api.js'

export default {
  setup() {

    const signIn = async () => {
      console.log(email.value, password.value)
      const isSignIn = await UserSignIn(email.value, password.value)
      if (isSignIn) {
        router.push({ path: 'chat' })
        // await FetchUsers()
      }
    }


    return {
      signIn
    }
  }
}
</script>
<style scoped>
</style>
