<template>
  <app-modal
    :showModal="showModal"
    :showAction="true"
    :showCancel="false"
    actionText="終了"
  >
    <template v-slot:app-icon>
      <user-icon class="h-5 w-5" />
    </template>
    <template v-slot:app-title>作成完了</template>
    <template v-slot:app-content>チャンネルの作成が完了しました！</template>
  </app-modal>
</template>
<script>
export default {
  props: ["showModal"],
}
</script>
