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
        ref="channelName"
        class="mb-2"
        type="text"
        v-model="checkChannelName"
        @event:updateText="updateAddChannelName"
        name="channel_name"
        id="channel_name"
        placeholder="チャンネル名"
      />
      <div v-for="(error, index) in v$.checkChannelName.$errors" :key="index" class="text-xs text-red-500 mb-2">
        <div v-if="error.$validator == 'required'">チャンネル名は必須です。</div>
        <div v-if="error.$validator == 'maxLength'">チャンネル名は255文字以下で入力してください。</div>
      </div>
      <form-label class="mb-2" forText="description" showText="説明" />
      <form-text
        ref="channelDescription"
        class="mb-2"
        type="description"
        v-model="checkChannelDescription"
        @event:updateText="updateAddChannelDescription"
        name="description"
        id="description"
        placeholder="説明"
      />
      <div v-for="(error, index) in v$.checkChannelDescription.$errors" :key="index" class="text-xs text-red-500 mb-2">
        <div v-if="error.$validator == 'required'">チャンネルの説明は必須です。</div>
        <div v-if="error.$validator == 'maxLength'">チャンネルの説明は1024文字以下で入力してください。</div>
      </div>
      <span>プライベート設定</span>
      <form-checkbox
        ref="channelIsPrivate"
        label="プライベートチャンネルにする"
        @event:updateCheck="updateAddChannelIsPrivate"
      />
    </template>
  </app-modal>
</template>
<script>
import { ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, maxLength } from '@vuelidate/validators'

export default {
  props: ["showModal"],
  setup(props, context) {
    const channelName = ref('')
    const channelDescription = ref('')
    const checkChannelName = ref('')
    const checkChannelDescription = ref('')
    const channelIsPrivate = ref(false)

    /**
     * チャンネル名を更新するためのemitする
     * @param {string} text チャンネル名
     */
    const updateAddChannelName = (text) => {
      context.emit("event:updateAddChannelName", text);
    }

    /**
     * 説明を更新するためのemitする
     * @param {string} text チャンネル名
     */
    const updateAddChannelDescription = (text) => {
      context.emit("event:updateAddChannelDescription", text);
    }

    /**
     * プライベート設定を更新するためのemitする
     * @param {string} text チャンネル名
     */
    const updateAddChannelIsPrivate = (value) => {
      context.emit("event:updateAddChannelIsPrivate", value);
    }

    /**
     * モーダルの入力値バリデーションを行う
     * @return {boolean} true(error)/false(no error)
     */
    const modalValidateError = async () => {
      const isFormCorrect = await v$.value.$validate()
      return !isFormCorrect
    }

    const rules = {
      checkChannelName: { required, maxLength: maxLength(255) },
      checkChannelDescription: { required, maxLength: maxLength(1024) }
    }

    const v$ = useVuelidate(rules, { checkChannelName, checkChannelDescription })

    return {
      updateAddChannelName,
      updateAddChannelDescription,
      updateAddChannelIsPrivate,
      channelName,
      channelDescription,
      channelIsPrivate,
      checkChannelName,
      checkChannelDescription,
      v$,
      modalValidateError
    }
  },
}
</script>
