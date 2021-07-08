<template>
  <div class="w-10/12 m-auto text-center">
    <app-title class="pt-8 pb-8 pr-10" />
    <sign-in-text>Join laravel-vue-slack.</sign-in-text>
    <div class="w-96 m-auto text-left pt-8">
      <div>Email address</div>
      <div class="mb-5">{{ sendEmail }}</div>
      <form-label class="mb-2" forText="name" showText="User Name" />
      <form-text  class="mb-5" type="text" v-model="inputName" name="user_name" id="user_name" placeholder="User name" />
      <form-label class="mb-2" forText="password" showText="Password" />
      <form-text  class="mb-5" type="password" v-model="inputPassword" name="password" id="password" placeholder="Your password" />
      <account-create-button @event:AccountCreate="accountCreate" />
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { CreateUser } from '../../apis/user.api.js'
export default {
  props: ['sendEmail'],
  setup(props) {
    let inputName = ref('')
    let inputPassword = ref('')

    const accountCreate = async () => {
        const created = await CreateUser(props.sendEmail, inputName.value, inputPassword.value)
        if (created) {
            location.href = location.protocol + "//" +location.host + "/#/chat"
        }
    }

    return {
      accountCreate,
      inputName,
      inputPassword
    }
  }
}
</script>
<style scoped>
</style>
