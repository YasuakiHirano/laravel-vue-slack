<template>
    <div>
        <div class="fixed h-10 w-screen head-color overflow-y-hidden">
        </div>
        <div class="fixed h-screen w-3/12 side-menu mt-10">
            <div class="p-3 mb-3 text-white border-t-2 border-b-2 slack-name-area">
                LaravelVueSlack
            </div>
            <div class="pl-3 pb-2 text-sm text-white text-opacity-50">スレッド</div>
            <div class="pl-3 pb-2 text-sm text-white text-opacity-50">メンション＆リアクション</div>
            <div class="pl-3 pb-2 text-sm text-white text-opacity-50">チャンネル</div>
        </div>
        <div class="flex h-screen">
            <div class="w-3/12 empty-side-menu">&nbsp;</div>
            <div class="w-screen mt-10 pl-3 pt-3 overflow-y-scroll">
                <div class="w-11/12 pl-2">
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                    test<br/>
                </div>
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
.head-color {
  background-color:#350d36;
}
.side-menu {
  background-color:#3F0E40;
  min-width: 15rem;
  max-width: 15rem;
}
.empty-side-menu {
  min-width: 15rem;
  max-width: 15rem;
}
.slack-name-area {
  border-color:#521953;
  border-width: 1px;
  font-weight: bold;
}
</style>
