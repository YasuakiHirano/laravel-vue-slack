<template>
  <div class="w-10/12 m-auto text-center">
    <app-title class="pt-8 pb-8 pr-10" />
    <sign-in-text>Sign in to laravel-vue-slack.</sign-in-text>
    <div class="w-96 m-auto text-left pt-8">
      <sign-in-form-label class="mb-2" forText="email" showText="Email address" />
      <sign-in-form-text  class="mb-2" type="text" name="email" id="email" placeholder="name@example.com" />
      <sign-in-form-label class="mb-2" forText="password" showText="Password" />
      <sign-in-form-text  class="mb-5" type="password" name="password" id="password" placeholder="Your password" />
      <sign-in-button @event:SignIn="signIn" />
    </div>
  </div>
</template>

<script>
import router from '../../router/index.js';

export default {
  setup() {
    const signIn = () => {
      router.push({ path: 'chat' })
    }

    return {
      signIn
    }
  }
}
</script>
<style scoped>
</style>
