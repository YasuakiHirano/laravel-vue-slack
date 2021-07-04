<template>
  <input :type="type" :name="name" :id="id" :placeholder="placeholder" class="w-full p-2 rounded-md border border-gray-500 shadow-sm focus:ring-4 focus:ring-blue-300" />
</template>
<script>
export default {
  props: ['type', 'name', 'id', 'placeholder']
}
</script>
