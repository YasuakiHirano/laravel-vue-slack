<template>
  <app-modal
    :showModal="showModal"
    :showAction="false"
    :showCancel="true"
    :wideDialog="true"
    cancelText="閉じる"
  >
    <template v-slot:app-icon>
      <user-icon class="h-5 w-5" />
    </template>
    <template v-slot:app-title>スレッド</template>
    <template v-slot:app-content>
        TODO
    </template>
  </app-modal>
</template>
<script>
export default {
  props: ["showModal"],
  setup(props, context) {
  },
}
</script>
