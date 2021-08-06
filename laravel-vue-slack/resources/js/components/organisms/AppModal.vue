<template>
  <div class="fixed inset-0 w-full h-full bg-black bg-opacity-60 z-50 flex items-center justify-center" v-show="showModal">
    <div :class="'inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full'">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-white border-2 border-gray-800 sm:mx-0 sm:h-10 sm:w-10">
            <slot name="app-icon" />
          </div>
          <div class="mt-3 w-full text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
              <slot name="app-title" />
            </h3>
            <div class="mt-2 w-full">
              <slot name="app-content" />
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
      <form-action-button @click="$emit('event:modalAction')" v-show="showAction">
        {{ actionText }}
      </form-action-button>
      <form-cancel-button @click="$emit('event:modalClose')" v-show="showCancel">
        {{ cancelText }}
      </form-cancel-button>
      </div>
    </div>
  </div>
</template>
<script>
export default ({
  props:['showModal', 'actionText', 'cancelText', 'showAction', 'showCancel', 'wideDialog']
})
</script>

