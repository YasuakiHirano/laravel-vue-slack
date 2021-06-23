<template>
  <div class="border rounded-md w-14 hover:bg-gray-100 cursor-pointer flex justify-between">
      <div class="m-1 ml-2">
        <user-icon class="h-5 w-5" />
      </div>
      <div class="mt-1 mr-3 text-sm">
        <slot />
      </div>
  </div> 
</template>