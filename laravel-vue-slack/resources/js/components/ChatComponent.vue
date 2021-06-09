<template>
    <div class="main">
        <div class="header">
        </div>
        <div class="side-menu">
            <div class="p-3 mb-3 text-white border-t-2 border-b-2 slack-name-area">
                LaravelVueSlack
            </div>
            <div class="pl-3 pb-2 text-sm text-white text-opacity-50">スレッド</div>
            <div class="pl-3 pb-2 text-sm text-white text-opacity-50">メンション＆リアクション</div>
            <div class="pl-3 pb-2 text-sm text-white text-opacity-50">チャンネル</div>
        </div>
        <div class="message-area">
            <div>
                test<br/>
                test<br/>
                test<br/>
            </div>
            <div class="text-area text-center">
                <textarea class="resize-none border border-gray-800 rounded-md p-3 input-text h-4/5 mt-2"></textarea>
                <div class="bg-gray-200 border-gray-500 icon-area rounded-md border">icon area</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  mounted() {
    console.log('Component mounted.')
  }
}
</script>
<style scoped>
.main {
  display: grid;
  grid-template-columns: minmax(180px, 20%) 1fr;
  grid-auto-rows: 30px calc(100vh - 30px);
  min-height: 100vh;
  margin: 0;
}
.header {
  grid-row: 1;
  grid-column: 1 / span 2;
  background-color:#350d36;
}
.side-menu {
  grid-row: 2;
  grid-column: 1;
  overflow-y: scroll;
  overflow-x: hidden;
  background-color:#3F0E40;
}
.message-area {
  grid-row: 2;
  grid-column: 2;
  overflow-y: hidden;
  overflow-x: hidden;

  display: grid;
  grid-auto-rows: 1fr 100px;
}
.input-text{
  width: 97%;
}
.icon-area {
  text-align: right;
  position: absolute;
  width: 200px;
  height: 35px;
  bottom: 13px;
  right: 16px;
}
</style>
