<template>
    <div class="main">
        <div class="header"></div>
        <div class="side-menu">
            <div class="p-3 mb-3 text-white border-l-0 border-r-0 border border-white border-opacity-20">
                laravel-vue-slack
            </div>
            <div class="pl-3 pb-2 text-sm text-white text-opacity-70 cursor-pointer flex">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
              </svg>
              スレッド</div>
            <div class="pl-3 pb-2 text-sm text-white text-opacity-70 cursor-pointer flex">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z" clip-rule="evenodd" />
              </svg>
              メンション＆リアクション
            </div>
            <div class="pl-3 pb-2 text-sm text-white text-opacity-70 cursor-pointer flex justify-between" @click="toggleChannels()">
              <div class="flex">
                <template v-if="state.toggleChannel">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </template>
                <template v-else>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                  </svg>
                </template>
                チャンネル
              </div>
              <div class="mr-5 opacity-60 hover:opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
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
                <div class="border mr-4 w-14 rounded-md mt-2 mb-2 hover:bg-gray-100 cursor-pointer flex justify-between">
                    <div class="m-1 ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="mt-1 mr-3 text-sm">
                        10
                    </div>
                </div>
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
                    <div class="p-5 pt-0 flex hover:bg-gray-100 pt-1 pb-1 mt-1">
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
                        <div class="opacity-0 group-hover:opacity-100 bg-white border-2 border-gray-300 shadow-lg rounded-md border flex pt-1 pb-1 justify-end message-tool-area pr-3 pl-3">
                          <div class="mr-1 p-1 hover:bg-gray-200 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                          </div>
                          <div class="p-1 hover:bg-gray-200 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                          </div>
                        </div>
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
                <textarea class="resize-none border border-gray-800 rounded-md p-3 input-text h-4/5 mt-2" placeholder="#channel nameへのメッセージ"></textarea>
                <div class="bg-gray-200 border-gray-500 icon-area rounded-md border flex pt-1 pb-1 justify-end">
                  <div class="border border-green-800 bg-red-400 hover:bg-red-600 rounded p-1 ml-3 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <div class="border border-green-800 bg-yellow-400 hover:bg-yellow-600 rounded p-1 ml-3 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <div class="border border-green-800 bg-green-400 hover:bg-green-600 rounded p-1 ml-3 mr-3 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                  </div>
                </div>
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
.input-text{
  width: 97%;
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
