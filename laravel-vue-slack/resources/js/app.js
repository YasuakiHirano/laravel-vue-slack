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

// atoms
import AccountCreateButton from './components/atoms/AccountCreateButton.vue'
import SignInButton from './components/atoms/SignInButton.vue'
import SignInText from './components/atoms/SignInText.vue'
import FormLabel from './components/atoms/FormLabel.vue'
import FormText from './components/atoms/FormText.vue'
import FormCheckbox from './components/atoms/FormCheckbox.vue'
import FormActionButton from './components/atoms/FormActionButton.vue'
import FormCancelButton from './components/atoms/FormCancelButton.vue'
import FormDeleteButton from './components/atoms/FormDeleteButton.vue'
import ChatUserImage from './components/atoms/ChatUserImage.vue'
import ChatUserName from './components/atoms/ChatUserName.vue'
import ChatUserDate from './components/atoms/ChatUserDate.vue'
import ChatTextArea from './components/atoms/ChatTextArea.vue'
import ShowDate from './components/atoms/ShowDate.vue'
import ReactionIcon from './components/atoms/ReactionIcon.vue'
import ReactionNumber from './components/atoms/ReactionIcon.vue'
import CancelBorderIcon from './components/atoms/CancelBorderIcon.vue'
import MentionBorderIcon from './components/atoms/MentionBorderIcon.vue'
import ReactionBorderIcon from './components/atoms/ReactionBorderIcon.vue'
import SendMessageBorderIcon from './components/atoms/SendMessageBorderIcon.vue'
import SpeakerIcon from './components/atoms/SpeakerIcon.vue'
import ServiceTitle from './components/atoms/ServiceTitle.vue'
import ThreadIcon from './components/atoms/ThreadIcon.vue'
import MentionIcon from './components/atoms/MentionIcon.vue'
import ArrowLeftIcon from './components/atoms/ArrowLeftIcon.vue'
import ArrowRightIcon from './components/atoms/ArrowRightIcon.vue'
import ArrowBottomIcon from './components/atoms/ArrowBottomIcon.vue'
import PlusIcon from './components/atoms/PlusIcon.vue'
import HappyIcon from './components/atoms/HappyIcon.vue'
import UserIcon from './components/atoms/UserIcon.vue'
import LockIcon from './components/atoms/LockIcon.vue'
import HashIcon from './components/atoms/HashIcon.vue'
import EditIcon from './components/atoms/EditIcon.vue'
import DeleteIcon from './components/atoms/DeleteIcon.vue'
import CancelIcon from './components/atoms/CancelIcon.vue'
import UserInformation from './components/atoms/UserInformation.vue'
import Loading from './components/atoms/Loading.vue'

app.component('account-create-button', AccountCreateButton)
app.component('sign-in-text', SignInText)
app.component('sign-in-button', SignInButton)
app.component('form-label', FormLabel)
app.component('form-text', FormText)
app.component('form-checkbox', FormCheckbox)
app.component('form-action-button', FormActionButton)
app.component('form-cancel-button', FormCancelButton)
app.component('form-delete-button', FormDeleteButton)
app.component('chat-user-image', ChatUserImage)
app.component('chat-user-name', ChatUserName)
app.component('chat-user-date', ChatUserDate)
app.component('chat-text-area', ChatTextArea)
app.component('show-date', ShowDate)
app.component('reaction-icon', ReactionIcon)
app.component('reaction-number', ReactionNumber)
app.component('cancel-border-icon', CancelBorderIcon)
app.component('mention-border-icon', MentionBorderIcon)
app.component('reaction-border-icon', ReactionBorderIcon)
app.component('send-message-border-icon', SendMessageBorderIcon)
app.component('speaker-icon', SpeakerIcon)
app.component('service-title', ServiceTitle)
app.component('thread-icon', ThreadIcon)
app.component('mention-icon', MentionIcon)
app.component('arrow-left-icon', ArrowLeftIcon)
app.component('arrow-right-icon', ArrowRightIcon)
app.component('arrow-bottom-icon', ArrowBottomIcon)
app.component('plus-icon', PlusIcon)
app.component('happy-icon', HappyIcon)
app.component('user-icon', UserIcon)
app.component('lock-icon', LockIcon)
app.component('hash-icon', HashIcon)
app.component('edit-icon', EditIcon)
app.component('delete-icon', DeleteIcon)
app.component('cancel-icon', CancelIcon)
app.component('user-information', UserInformation)
app.component('loading', Loading)

// molecules
import AppTitle from './components/molecules/AppTitle.vue'
import ReactionCircle  from './components/molecules/ReactionCircle.vue'
import TextAreaIcons  from './components/molecules/TextAreaIcons.vue'
import MessageAreaIcons  from './components/molecules/MessageAreaIcons.vue'
import ChannelMenu  from './components/molecules/ChannelMenu.vue'
import UserEntryCount  from './components/molecules/UserEntryCount.vue'
import ChatHeader  from './components/molecules/ChatHeader.vue'
import LoadingDisplay  from './components/molecules/LoadingDisplay.vue'
import AddMember  from './components/molecules/AddMember.vue'
import ErrorAlert  from './components/molecules/ErrorAlert.vue'

app.component('app-title', AppTitle)
app.component('reaction-circle', ReactionCircle)
app.component('text-area-icons', TextAreaIcons)
app.component('message-area-icons', MessageAreaIcons)
app.component('channel-menu', ChannelMenu)
app.component('user-entry-count', UserEntryCount)
app.component('chat-header', ChatHeader)
app.component('loading-display', LoadingDisplay)
app.component('add-member', AddMember)
app.component('error-alert', ErrorAlert)

// organisms
import SideMenu  from './components/organisms/SideMenu.vue'
import ShowChannelName  from './components/organisms/ShowChannelName.vue'
import ChatInputArea  from './components/organisms/ChatInputArea.vue'
import ChatMessage  from './components/organisms/ChatMessage.vue'
import MentionUserArea  from './components/organisms/MentionUserArea.vue'
import AppModal  from './components/organisms/AppModal.vue'
app.component('side-menu', SideMenu)
app.component('show-channel-name', ShowChannelName)
app.component('chat-input-area', ChatInputArea)
app.component('chat-message', ChatMessage)
app.component('app-modal', AppModal)
app.component('mention-user-area', MentionUserArea)

// - modal
import AddMemberModal  from './components/organisms/AddMemberModal.vue'
import AddMemberSuccessModal  from './components/organisms/AddMemberSuccessModal.vue'
import AddChannelModal  from './components/organisms/AddChannelModal.vue'
import AddChannelSuccessModal  from './components/organisms/AddChannelSuccessModal.vue'
import ChannelDetailModal  from './components/organisms/ChannelDetailModal.vue'
import ChannelDescriptionEditModal  from './components/organisms/ChannelDescriptionEditModal.vue'
import ChannelAddMemberModal  from './components/organisms/ChannelAddMemberModal.vue'
import MentionMemberModal  from './components/organisms/MentionMemberModal.vue'
import ThreadModal  from './components/organisms/ThreadModal.vue'
app.component('add-member-modal', AddMemberModal)
app.component('add-member-success-modal', AddMemberSuccessModal)
app.component('add-channel-modal', AddChannelModal)
app.component('add-channel-success-modal', AddChannelSuccessModal)
app.component('channel-detail-modal', ChannelDetailModal)
app.component('channel-description-edit-modal', ChannelDescriptionEditModal)
app.component('channel-add-member-modal', ChannelAddMemberModal)
app.component('mention-member-modal', MentionMemberModal)
app.component('thread-modal', ThreadModal)

// page
import AccountCreate  from './components/pages/AccountCreate.vue'
app.component('account-create', AccountCreate)

// library
import EmojiPicker from "./components/organisms/EmojiPicker.vue"
app.component('emoji-picker', EmojiPicker)

// id="app"???????????????
app.mount('#app')
