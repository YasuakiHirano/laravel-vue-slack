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
        class="mb-2"
        type="text"
        @event:updateText="updateText"
        name="email"
        id="email"
        placeholder="name@example.com"
      />
    </template>
  </app-modal>
</template>
<script>
export default {
  props: ["showModal"],
  setup(props, context) {
    const updateText = (text) => {
      context.emit("event:updateText", text);
    }

    return {
      updateText,
    }
  },
}
</script>
