<template>
  <div class="w-10/12 m-auto text-center">
    <div class="text-3xl pt-8 pb-8 pr-10 flex justify-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-yellow-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      LaravelVueSlack
    </div>
    <div class="text-4xl">Sign in to laravel-vue-slack.</div>
    <div class="w-96 m-auto text-left pt-8">
      <div class="mb-2">
        <label for="email">Email address</label>
      </div>
      <input type="text" name="email" id="email" placeholder="name@example.com" class="w-full p-2 mb-5 rounded-md border border-gray-500 shadow-sm focus:ring-4 focus:ring-blue-300" />
      <div class="mb-2">
        <label for="password">Password</label>
      </div>
      <input type="password" name="password" id="password" placeholder="Your password" class="w-full p-2 rounded-md border border-gray-500 shadow-sm focus:ring-4 focus:ring-blue-300" />
      <button class="w-full rounded-md bg-blue-500 hover:bg-blue-700 text-2xl text-white pt-1 pb-1 mt-8" @click="signIn">Sign in</button>
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
