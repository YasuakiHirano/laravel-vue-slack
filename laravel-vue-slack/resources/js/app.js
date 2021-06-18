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

import ShowDate from './components/atoms/ShowDate.vue'
import ReactionIcon from './components/atoms/ReactionIcon.vue'
import ReactionNumber from './components/atoms/ReactionIcon.vue'

// molecules
import ReactionCircle  from './components/molecules/ReactionCircle.vue'

app.component('chat-user-image', ChatUserImage)
app.component('chat-user-name', ChatUserName)
app.component('chat-user-date', ChatUserDate)
app.component('show-date', ShowDate)
app.component('reaction-icon', ReactionIcon)
app.component('reaction-number', ReactionNumber)

app.component('reaction-circle', ReactionCircle)