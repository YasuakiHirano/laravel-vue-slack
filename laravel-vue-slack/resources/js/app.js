/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });


import { createApp } from 'vue'
import router from './router'

const app = createApp({})

app.use(router)
app.mount('#app')

// atoms
import ChatUserImage from './components/atoms/ChatUserImage.vue'
import ChatUserName from './components/atoms/ChatUserName.vue'
import ChatUserDate from './components/atoms/ChatUserDate.vue'
import ChatTextArea from './components/atoms/ChatTextArea.vue'
import ShowDate from './components/atoms/ShowDate.vue'
import ReactionIcon from './components/atoms/ReactionIcon.vue'
import ReactionNumber from './components/atoms/ReactionIcon.vue'
import MentionBorderIcon from './components/atoms/MentionBorderIcon.vue'
import ReactionBorderIcon from './components/atoms/ReactionBorderIcon.vue'
import SendMessageBorderIcon from './components/atoms/SendMessageBorderIcon.vue'
import ServiceTitle from './components/atoms/ServiceTitle.vue'
import ThreadIcon from './components/atoms/ThreadIcon.vue'
import MentionIcon from './components/atoms/MentionIcon.vue'
import ArrowRightIcon from './components/atoms/ArrowRightIcon.vue'
import ArrowBottomIcon from './components/atoms/ArrowBottomIcon.vue'
import PlusIcon from './components/atoms/PlusIcon.vue'
import HappyIcon from './components/atoms/HappyIcon.vue'
import UserIcon from './components/atoms/UserIcon.vue'

app.component('chat-user-image', ChatUserImage)
app.component('chat-user-name', ChatUserName)
app.component('chat-user-date', ChatUserDate)
app.component('chat-text-area', ChatTextArea)
app.component('show-date', ShowDate)
app.component('reaction-icon', ReactionIcon)
app.component('reaction-number', ReactionNumber)
app.component('mention-border-icon', MentionBorderIcon)
app.component('reaction-border-icon', ReactionBorderIcon)
app.component('send-message-border-icon', SendMessageBorderIcon)
app.component('service-title', ServiceTitle)
app.component('thread-icon', ThreadIcon)
app.component('mention-icon', MentionIcon)
app.component('arrow-right-icon', ArrowRightIcon)
app.component('arrow-bottom-icon', ArrowBottomIcon)
app.component('plus-icon', PlusIcon)
app.component('happy-icon', HappyIcon)
app.component('user-icon', UserIcon)

// molecules
import ReactionCircle  from './components/molecules/ReactionCircle.vue'
import TextAreaIcons  from './components/molecules/TextAreaIcons.vue'
import MessageAreaIcons  from './components/molecules/MessageAreaIcons.vue'
import MentionReactionMenu  from './components/molecules/MentionReactionMenu.vue'
import ThreadMenu  from './components/molecules/ThreadMenu.vue'
import ChannelMenu  from './components/molecules/ChannelMenu.vue'
import UserEntryCount  from './components/molecules/UserEntryCount.vue'

app.component('reaction-circle', ReactionCircle)
app.component('text-area-icons', TextAreaIcons)
app.component('message-area-icons', MessageAreaIcons)
app.component('mention-reaction-menu', MentionReactionMenu)
app.component('thread-menu', ThreadMenu)
app.component('channel-menu', ChannelMenu)
app.component('user-entry-count', UserEntryCount)

// organisms
import SideMenu  from './components/organisms/SideMenu.vue'
app.component('side-menu', SideMenu)