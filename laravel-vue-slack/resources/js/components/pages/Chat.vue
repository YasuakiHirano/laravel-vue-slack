<template>
    <div class="main">
        <div class="header"></div>
        <div class="side-menu">
            <service-title />
            <thread-menu />
            <mention-reaction-menu />
            <channel-menu class="pl-3" @click="toggleChannels()" :toggle="state.toggleChannel" />
            <div v-if="state.toggleChannel">
              <div class="m-auto w-9/12 text-white text-opacity-70 ">
              #&nbsp;&nbsp;general
              </div>
            </div>
        </div>
        <div class="message-area">
            <div class="border text-lg font-bold flex justify-between">
                <div class="pt-2 pl-5">
                  # channel name.
                </div>
                <user-entry-count class="mr-4 mt-2 mb-2">10</user-entry-count>
            </div>
            <div class="w-full overflow-y-scroll">
                <div class="border mt-5 border-b-0 w-full">
                    <div class="border -mt-3 bg-white p-1 rounded-3xl w-28 m-auto text-xs text-center font-bold">
                        6月9日(水)
                    </div>
                    <div class="p-5 pt-0 flex">
                        <div class="w-12">
                            <img src="image/user_image.png" class="w-11 border rounded-md" />
                        </div>
                        <div class="ml-2">
                            <div class="font-bold text-sm">user name<span class="ml-1 text-xs font-normal text-gray-400">8:00</span></div>
                            test<br/>
                            test<br/>
                            test<br/>
                        </div>
                    </div>
                </div>
                <div class="border mt-5 border-b-0 w-full">
                    <div class="border -mt-3 bg-white p-1 rounded-3xl w-28 m-auto text-xs text-center font-bold">
                        6月10日(木)
                    </div>
                    <div class="p-5 pt-0 flex">
                        <div class="w-12">
                            <img src="image/user_image.png" class="w-11 border rounded-md" />
                        </div>
                        <div class="ml-2">
                            <div class="font-bold text-sm">user name<span class="ml-1 text-xs font-normal text-gray-400">8:00</span></div>
                            test<br/>
                            test<br/>
                            test<br/>
                        </div>
                    </div>
                </div>
                <div class="border mt-5 border-b-0 w-full">
                    <div class="border -mt-3 bg-white p-1 rounded-3xl w-28 m-auto text-xs text-center font-bold">
                        6月11日(金)
                    </div>
                    <div class="p-5 pt-0 flex">
                        <div class="w-12">
                            <img src="image/user_image.png" class="w-11 border rounded-md" />
                        </div>
                        <div class="ml-2">
                            <div class="font-bold text-sm">user name<span class="ml-1 text-xs font-normal text-gray-400">8:00</span></div>
                            test<br/>
                            test<br/>
                            test<br/>
                        </div>
                    </div>
                </div>
                <div class="border mt-5 border-b-0 w-full">
                    <show-date>6月12日(土）</show-date>
                    <div class="group p-5 pt-0 flex hover:bg-gray-100 pt-1 pb-1 mt-1 relative">
                        <message-area-icons />
                        <div class="w-12">
                            <chat-user-image image="image/user_image.png" />
                        </div>
                        <div class="ml-2">
                            <div><chat-user-name>taro</chat-user-name><chat-user-date>08:00</chat-user-date></div>
                            test<br/>
                            test<br/>
                            test<br/>
                            <div class="flex mt-1">
                                <reaction-circle :number="5" icon="😆" class="mr-1" />
                                <reaction-circle :number="10" icon="👍" class="mr-1"  />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border mt-5 border-b-0 w-full">
                    <div class="border -mt-3 bg-white p-1 rounded-3xl w-28 m-auto text-xs text-center font-bold">
                        今日
                    </div>
                    <div class="group p-5 pt-0 flex hover:bg-gray-100 pt-1 pb-1 mt-1 relative">
                        <message-area-icons />
                        <div class="w-12">
                            <img src="image/user_image.png" class="w-11 border rounded-md" />
                        </div>
                        <div class="ml-2">
                            <div class="font-bold text-sm">user name<span class="ml-1 text-xs font-normal text-gray-400">8:00</span></div>
                            test<br/>
                            test<br/>
                            test<br/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-area text-center">
                <chat-text-area class="mt-2" />
                <text-area-icons class="icon-area" />
            </div>
        </div>
    </div>
</template>

<script>
import { reactive } from 'vue';
export default {
  setup() {
    const state = reactive({
      toggleChannel: false
    });

    const toggleChannels = () => {
      if (state.toggleChannel) {
        state.toggleChannel = false;
      } else {
        state.toggleChannel = true;
      }
    }
    return {
      state,
      toggleChannels
    }
  },
}
</script>
<style scoped>
.main {
  display: grid;
  grid-template-columns: minmax(210px, 20%) 1fr;
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
  grid-auto-rows: 50px 1fr 100px;
}
.icon-area {
  text-align: right;
  position: absolute;
  width: 145px;
  height: 40px;
  bottom: 18px;
  right: 20px;
}
.message-tool-area {
  position: absolute;
  height: 40px;
  top: -15px;
  right: 30px;
}
@media screen and (max-width: 500px) {
  .main {
    grid-template-columns: 1fr;
  }
  .side-menu {
    display: none;
  }
  .message-area {
    grid-column: 1;
  }
}
</style>
