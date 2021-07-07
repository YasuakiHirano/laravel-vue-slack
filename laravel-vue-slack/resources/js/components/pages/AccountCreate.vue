<template>
  <div class="w-10/12 m-auto text-center">
    <app-title class="pt-8 pb-8 pr-10" />
    <sign-in-text>Join laravel-vue-slack.</sign-in-text>
    <div class="w-96 m-auto text-left pt-8">
      <div>Email address</div>
      <div class="mb-5" >{{ sendEmail }}</div>
      <form-label class="mb-2" forText="name" showText="User Name" />
      <form-text  class="mb-5" type="text" v-model="userName" name="user_name" id="user_name" placeholder="User name" />
      <form-label class="mb-2" forText="password" showText="Password" />
      <form-text  class="mb-5" type="password" v-model="password" name="password" id="password" placeholder="Your password" />
      <account-create-button @event:AccountCreate="accountCreate" />
    </div>
  </div>
</template>

<script>
export default {
  props: ['sendEmail'],
  setup(props) {
    console.log(props.sendEmail)
    let email = ''

    email = 'test'

    const accountCreate = async () => {
    }

    return {
      accountCreate,
      email
    }
  }
}
</script>
<style scoped>
</style>
