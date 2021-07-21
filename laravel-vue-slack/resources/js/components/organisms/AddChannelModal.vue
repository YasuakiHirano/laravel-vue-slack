<template>
  <app-modal
    :showModal="showModal"
    :showAction="true"
    :showCancel="true"
    actionText="追加"
    cancelText="キャンセル"
  >
    <template v-slot:app-icon>
      <speaker-icon class="h-5 w-5" />
    </template>
    <template v-slot:app-title> チャンネルを追加します。 </template>
    <template v-slot:app-content>
      <form-label class="mb-2" forText="channel_name" showText="名前" />
      <form-text
        class="mb-2"
        type="text"
        @event:updateText="updateAddChannelName"
        name="channel_name"
        id="channel_name"
        placeholder="チャンネル名"
      />
      <form-label class="mb-2" forText="description" showText="説明" />
      <form-text
        class="mb-2"
        type="description"
        @event:updateText="updateAddChannelDescription"
        name="description"
        id="description"
        placeholder="説明"
      />
      <span>プライベート設定</span>
      <form-checkbox
        label="プライベートチャンネルにする"
        @event:updateCheck="updateAddChannelIsPrivate"
      />
    </template>
  </app-modal>
</template>
<script>
export default {
  props: ["showModal"],
  setup(props, context) {
    const updateAddChannelName = (text) => {
      context.emit("event:updateAddChannelName", text);
    }

    const updateAddChannelDescription = (text) => {
      context.emit("event:updateAddChannelDescription", text);
    }

    const updateAddChannelIsPrivate = (value) => {
      context.emit("event:updateAddChannelIsPrivate", value);
    }

    return {
      updateAddChannelName,
      updateAddChannelDescription,
      updateAddChannelIsPrivate,
    }
  },
}
</script>
