<template>
    <div class="main">
        <loading-display :isShow="showLoading" />
        <chat-header class="header" :userName="userName" />
        <side-menu
          class="side-menu"
          :channelId="selectChannel"
          @event:SelectChannel="changeChannel"
          @event:FetchChannels="fetchChannels"
          @event:AddMember="showAddMember = true"
          @event:AddChannel="showAddChannel = true" />
        <div class="message-area">
          <show-channel-name
            :channelId="selectChannel"
            :count="userCount"
            @event:clickCountChannel="isChannelTab = false;showChannelDetail = true;"
            @event:openChannelDetail="isChannelTab = true;showChannelDetail = true;"
            @event:isChannelUpdate="isChannelUpdate"
          >
              <div class="flex">
                <div v-if="isChannelPublic"><hash-icon class="mt-1 w-5 h-5"></hash-icon></div>
                <div v-else><lock-icon class="mt-1 w-5 h-5"></lock-icon></div>
                <div class="mr-1">{{ channelName }}</div>
              </div>
          </show-channel-name>
          <div class="w-full overflow-y-scroll" ref="messageListArea">
            <transition-group name="list" tag="div">
              <div v-for="(message, index) in messages" :key="message.id" :ref="chatMessages">
                 <chat-message
                   class="mt-5 w-full"
                   :channelId="selectChannel"
                   :messageId="message.id"
                   :date="message.date"
                   :imagePath="message.imagePath"
                   :postUserName="message.postUserName"
                   :postTime="message.postTime"
                   :reactions="message.reactions"
                   :mentions="message.mentions"
                   :content="message.content"
                   :isMyMessage="userName === message.postUserName"
                   :userId="userId"
                   :isThreadCount="message.isThreadCount"
                   :showThreadIcon="true"
                   @event:reactionMessage="reactionMessage"
                   @event:threadMessage="threadMessage"
                   @event:updateAreaReaction="updateAreaReaction(index)" />
              </div>
            </transition-group>
          </div>
          <chat-input-area
            ref="chatInputArea"
            @event:clickMentionIcon="isShowMentionMember = true"
            @event:clickReactionIcon="isShowEmojiPicker = true"
            @evnet:deleteMentionUser="deleteMentionUser"
            :userId="userId"
            :channelId="selectChannel"
            :channelName="channelName"
            :isMention="true"
            class="mt-2" />
        </div>
        <!--モーダル実装-->
        <!----メンバー招待---->
        <add-member-modal
          ref="addMemberModal"
          :showModal="showAddMember"
          @event:modalAction="sendInvitationMail"
          @event:modalClose="showAddMember = false"
          @event:updateText="updateEmail" />
        <add-member-success-modal
          :showModal="showAddMemberSuccess"
          @event:modalAction="showAddMemberSuccess = false" />
        <!----チャンネル追加---->
        <add-channel-modal
          ref="addChannelModal"
          :showModal="showAddChannel"
          @event:modalClose="showAddChannel = false"
          @event:modalAction="addChannel"
          @event:updateAddChannelName="updateAddChannelName"
          @event:updateAddChannelDescription="updateAddChannelDescription"
          @event:updateAddChannelIsPrivate="updateAddChannelIsPrivate" />
        <add-channel-success-modal
          :showModal="showAddChannelSuccess"
          @event:modalAction="showAddChannelSuccess = false" />
        <!----チャンネル情報表示---->
        <channel-detail-modal
          :showModal="showChannelDetail"
          :isChannelTab="isChannelTab"
          :channelId="selectChannel"
          :channelUsers="channelUsers"
          :description="channelDescription"
          :createUser="channelCreateUser"
          :isChannelPublic="isChannelPublic"
          :channelName="channelName"
          @event:editChannelDescription="showEditChannelDescription = true"
          @event:addChannelMember="showAddChannelMember = true"
          @event:modalAction="showChannelDetail = false" />
        <!----チャンネル説明編集---->
        <channel-description-edit-modal
          :showModal="showEditChannelDescription"
          :description="channelDescription"
          @event:modalAction="updateChannelDescription"
          @event:updateDescription="updateDescription"
          @event:modalClose="showEditChannelDescription = false" />
        <!----チャンネルメンバー追加---->
        <channel-add-member-modal
          ref="channelAddMemberModal"
          :showModal="showAddChannelMember"
          :notChannelUsers="notChannelUsers"
          @event:addUsers="channelAddUsers"
          @event:modalClose="showAddChannelMember = false" />
        <!----リアクション用の絵文字ピッカー---->
        <emoji-picker
          class="fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center"
          @event:selectEmoji="reactionEmoji"
          :isShow="isShowCenterEmojiPicker" />
        <div
          class="absolute w-full h-full"
          @click="isShowEmojiPicker = false"
          v-show="isShowEmojiPicker">
        </div>
        <!----絵文字入力用の絵文字ピッカー---->
        <emoji-picker
          class="absolute bottom-20 right-4"
          @event:selectEmoji="inputEmoji"
          :isShow="isShowEmojiPicker" />
        <!----メンションユーザー選択---->
        <mention-member-modal
          ref="mentionMemberModal"
          :showModal="isShowMentionMember"
          :channelUsers="channelUsers"
          @event:modalClose="isShowMentionMember = false"
          @event:mentionUsers="selectMentionUsers"
        />
        <!----スレッド---->
        <thread-modal
          ref="threadModal"
          :showModal="isShowThread"
          :message="threadMessageParam"
          :channelId="selectChannel"
          :channelUsers="channelUsers"
          :userId="userId"
          :userName="userName"
          @event:reactionMessage="reactionMessage"
          @event:modalClose="isShowThread = false"
        />
    </div>
</template>

<script>
import { onMounted, onBeforeUpdate, ref, nextTick, callWithAsyncErrorHandling } from 'vue'
import { FindUser } from '../../apis/user.api.js'
import { SendInvitationMail } from '../../apis/mail.api.js'
import { FetchMessages, FetchThreadMessages } from '../../apis/message.api.js'
import { CreateChannel, UpdateChannel } from '../../apis/channel.api.js'
import { CreateChannelUsers, FetchChannelUsers, FetchNotChannelUsers } from '../../apis/channelUser.api.js'
import { CreateOrUpdateReaction } from '../../apis/reaction.api.js'

export default {
  setup(props, context) {
    const userId = ref(0)
    const userName = ref('')
    const userCount = ref(0)
    const email = ref('')
    const channelName = ref('')
    const channelDescription = ref('')
    const channelCreateUser = ref('')
    const channelList = ref('')
    const channelUsers = ref([])
    const notChannelUsers = ref([])
    const isChannelTab = ref(true)
    const isChannelPublic = ref(false)
    const selectChannel = ref(1)
    const messages = ref([])
    const showLoading = ref(true)
    const showAddMember = ref(false)
    const showAddMemberSuccess = ref(false)
    const showChannelDetail = ref(false)
    const showEditChannelDescription = ref(false)
    const showAddChannelMember = ref(false)
    const messageListArea = ref(null)
    const showAddChannel = ref(false)
    const showAddChannelSuccess = ref(false)
    const addChannelName = ref('')
    const addChannelDescription = ref('')
    const addChannelIsPrivate = ref(false)
    const isShowEmojiPicker = ref(false)
    const isShowCenterEmojiPicker = ref(false)
    const isShowMentionMember = ref(false)
    const threadMessageParam = ref([])
    const isShowThread = ref(false)
    const selectMessageId = ref(0)
    const chatInputArea = ref(null)
    const mentionMemberModal = ref(null)
    const threadModal = ref(null)
    const chatMessageItems = ref([])
    const addChannelModal = ref(null)
    const addMemberModal = ref(null)
    const channelAddMemberModal = ref(null)

    let isUpdateEditReaction = false
    let selectChatMessageKey = 0

    onBeforeUpdate(() => {
      chatMessageItems.value = []
    })

    onMounted(async () => {
      await initLoading()
      if (Push.Permission.has() == false) {
        Push.create('laravel-vue-slackへようこそ')
      }
    })

    /**
     * メッセージ一覧のテキストエリアを配列に設定する
     * @param {HTMLElement} el
     */
    const chatMessages = (el) => {
      if (el) {
        chatMessageItems.value.push(el)
      }
    }

    /**
     * メンバー招待モーダルで入力されたテキストをemail変数に反映する
     * @param {string} text
     */
    const updateEmail = (text) => {
      email.value = text.value
    }

    /**
     * メンバー招待モーダルからのメール送信処理
     */
    const sendInvitationMail = async () => {
      const error = await addMemberModal.value.modalValidateError()
      if (error) return

      showAddMember.value = false
      showLoading.value = true

      // 招待メールの送信
      await SendInvitationMail(email.value)

      // 入力値のクリア
      addMemberModal.value.checkEmailAddress = ''
      addMemberModal.value.emailAddress.text = ''
      addMemberModal.value.v$.$reset()

      showLoading.value = false
      showAddMemberSuccess.value = true
    }

    /**
     * チャンネル追加モーダルの名前を変数に反映する
     * @param {string} text
     */
    const updateAddChannelName = (text) => {
      addChannelName.value = text.value
    }

    /**
     * チャンネル追加モーダルの説明を変数に反映する
     * @param {string} text
     */
    const updateAddChannelDescription = (text) => {
      addChannelDescription.value = text.value
    }

    /**
     * チャンネル追加モーダルのプライベート設定を変数に反映する
     * @param {boolean} text
     */
    const updateAddChannelIsPrivate = (value) => {
      addChannelIsPrivate.value = value
    }


    /**
     * チャンネル追加モーダルからのチャンネル作成処理
     */
    const addChannel = async () => {
      const error = await addChannelModal.value.modalValidateError()
      if (error) return

      showAddChannel.value = false
      showLoading.value = true

      // チャンネルを作成する
      await CreateChannel(addChannelName.value, addChannelDescription.value, addChannelIsPrivate.value)

      // 入力した内容のクリア
      addChannelModal.value.channelName.text = ''
      addChannelModal.value.channelDescription.text = ''
      addChannelModal.value.channelIsPrivate.check = ''
      addChannelModal.value.checkChannelName = ''
      addChannelModal.value.checkChannelDescription = ''
      addChannelModal.value.v$.$reset()

      showLoading.value = false
      showAddChannelSuccess.value = true
    }

    /**
     * メッセージエリアを一番下までスクロールする
     */
    const scrollMessageListArea = () => {
      messageListArea.value.scrollTop = messageListArea.value.scrollHeight;
    }

    /**
     * チャンネルを選択したときの処理
     */
    const changeChannel = async (channelId) => {
      selectChannel.value = channelId

      // 初期ローディングを動かす
      await initLoading()

      // チャンネル情報を設定する
      findChannelName()
    }

    /**
     * SideMenuからチャンネル一覧を受け取る
     * @param {array} channels チャンネル一覧
     */
    const fetchChannels = (channels) => {
      channelList.value = channels

      // チャンネル情報を設定する
      findChannelName()
    }

    /**
     * チャンネル一覧からチャンネル情報を取得して設定する
     */
    const findChannelName = () => {
      const channel = channelList.value.find(channel => channel.id === selectChannel.value)

      channelName.value = channel.name
      channelDescription.value = channel.description
      channelCreateUser.value = channel.create_user
      isChannelPublic.value = channel.is_public ? true : false
    }

    /**
     * チャンネルの説明箇所を更新する
     */
    const updateChannelDescription = async () => {
      // チャンネルの説明を更新
      await UpdateChannel(selectChannel.value, null, channelDescription.value, null)
      showEditChannelDescription.value = false
    }

    /**
     * チャンネルの説明変数を更新する
     */
    const updateDescription = (text) => {
      channelDescription.value = text
    }

    /**
     * チャンネル詳細モーダルのタブを切り替えたとき
     */
    const isChannelUpdate = (value) => {
      isChannelTab.value = value
    }

    /**
     * テキストエリアの絵文字ピッカーで絵文字の選択時処理
     */
    const inputEmoji = (emoji) => {
      if (chatInputArea.value.chatTextArea.text === undefined || chatInputArea.value.chatTextArea.text === null) {
        chatInputArea.value.chatTextArea.text = ''
      }

      chatInputArea.value.chatTextArea.text += emoji.native
      isShowEmojiPicker.value = false
    }

    /**
     * メッセージ一覧のメッセージ編集でリアクションがクリックされた時
     */
    const updateAreaReaction = (index) => {
      selectChatMessageKey = index
      isUpdateEditReaction = true
      isShowCenterEmojiPicker.value = true
    }

    /**
     * リアクション用絵文字ピッカーで絵文字が選択された時
     */
    const reactionEmoji = async (emoji) => {
      if (isUpdateEditReaction) {
        // メッセージ編集の場合は編集モードのテキストエリアに表示
        chatMessageItems.value[selectChatMessageKey].querySelector("textarea").value += emoji.native
        chatMessageItems.value[selectChatMessageKey].querySelector("textarea").dispatchEvent(new Event('input'))

        isUpdateEditReaction = false
        isShowCenterEmojiPicker.value = false
      } else {
        // メッセージに対してのリアクションの場合は追加または更新する
        await CreateOrUpdateReaction(selectMessageId.value, userId.value, emoji.id, emoji.native)
        isShowCenterEmojiPicker.value = false
      }
    }

    /**
     * チャンネルにユーザーを追加する処理
     * @param {array} addUsers チャンネルに追加するユーザーID配列
     */
    const channelAddUsers = async (addUsers) => {
      // チャンネルにユーザーを追加する
      await CreateChannelUsers(selectChannel.value, addUsers)

      // 選択していた追加ユーザーのクリア
      channelAddMemberModal.value.selectUsers = []
      showAddChannelMember.value = false
    }

    /**
     * メンションするユーザーを選択された時の処理
     */
    const selectMentionUsers = (mentionUsers) => {
      chatInputArea.value.mentionUserArea.mentionUsers = mentionUsers
      isShowMentionMember.value = false
    }

    /**
     * メンションの削除ボタンが押された時の処理
     */
    const deleteMentionUser = (mentionUser) => {
      chatInputArea.value.mentionUserArea.mentionUsers = chatInputArea.value.mentionUserArea.mentionUsers.filter((user) => { return user !== mentionUser })
      mentionMemberModal.value.selectUsers = mentionMemberModal.value.selectUsers.filter((user) => { return user !== mentionUser })
    }

    /**
     * 画面表示時のローディング処理
     */
    const initLoading = async() => {
      // ローディングを表示する
      showLoading.value = true

      // ユーザー取得
      const user = await FindUser()
      userId.value = user.id
      userName.value = user.name

      // チャンネルのユーザー取得
      channelUsers.value = await FetchChannelUsers(selectChannel.value);
      userCount.value = channelUsers.value.length

      // チャンネルに属していないユーザー取得
      notChannelUsers.value = await FetchNotChannelUsers(selectChannel.value);

      // 選択中のチャンネルメッセージ取得
      messages.value = await FetchMessages(selectChannel.value)

      // ローディングを非表示にする
      showLoading.value = false

      nextTick(() => {
        scrollMessageListArea()
      })
    }

    /**
     * リアクションボタンを押された時の処理
     * @param {int} messageId リアクションをつけるメッセージID
     */
    const reactionMessage = (messageId) => {
      isShowCenterEmojiPicker.value = true
      selectMessageId.value = messageId
    }

    /**
     * スレッドボタンを押された時の処理
     * @param {int} messageId スレッドを開くメッセージID
     */
    const threadMessage = async (messageId) => {
      showLoading.value = true

      const message = messages.value.filter(function (message) { return message.id == messageId } )
      threadMessageParam.value = message[0]
      isShowThread.value = true

      const threadMessages = await FetchThreadMessages(message[0].id)
      threadModal.value.threadMessages = threadMessages
      threadModal.value.parentMessageId = message[0].id

      nextTick(() => {
        threadModal.value.scrollMessageListArea()
        showLoading.value = false
      })
    }

    /**
     * メッセージを作成した時のブロードキャスト受信
     */
    window.Echo.channel("create-message").listen('.MessageEvent', result => {
      if (result.isThreadMessage) {
        threadModal.value.threadMessages.push(result.message)
        messages.value.filter(function (message) {
          if (message.id == threadMessageParam.value.id) {
            message.isThreadCount = threadModal.value.threadMessages.length
          }
        })

        nextTick(() => {
          threadModal.value.scrollMessageListArea()
        })
      } else {
        messages.value.push(result.message)

        nextTick(() => {
          scrollMessageListArea()
        })
      }
    })

    /**
     * メッセージを削除した時のブロードキャスト受信
     */
    window.Echo.channel("delete-message").listen('.MessageEvent', result => {
      const messageId = result.messageId

      if (result.isThreadMessage) {
        threadModal.value.threadMessages = threadModal.value.threadMessages.filter(function (message) { return message.id != messageId } )
      } else {
        messages.value = messages.value.filter(function (message) { return message.id != messageId } )
      }
    })

    /**
     * メッセージを更新した時のブロードキャスト受信
     */
    window.Echo.channel("update-message").listen('.MessageEvent', result => {
      const content = result.message
      const messageId = result.messageId

      if (result.isThreadMessage) {
        threadModal.value.threadMessages.filter((message) => {
          if (message.id == messageId) {
            message.content = content
          }
        })
      } else {
        messages.value.filter((message) => {
          if (message.id == messageId) {
            message.content = content
          }
        })
      }
    })

    /**
     * チャンネルを追加した時のブロードキャスト受信
     */
    window.Echo.channel("create-channel").listen('.ChannelEvent', result => {
      if (result.makeUserId === userId.value) {
        channelList.value.push(result.channelObject[0])
      }
    })

    /**
     * チャンネルにユーザーを追加した時のブロードキャスト受信
     */
    window.Echo.channel("create-channel-user").listen('.ChannelUserEvent', result => {
      // メンバーが追加されたときに、追加したユーザーだった場合
      if (selectChannel.value == result.channelId) {
        channelUsers.value = result.channelUsers

        // メンバー追加用ユーザーから追加したユーザーを消す
        channelUsers.value.filter((channelUser) => {
          notChannelUsers.value = notChannelUsers.value.filter((notChannelUser) => {
            return channelUser.name != notChannelUser.name
          })
        })

        userCount.value = channelUsers.value.length
      } else {
        let channelNames = []
        channelList.value.filter((channel) => { channelNames.push(channel.name) })

        channelUsers.value.filter((channelUser) => {
          const channelObject = result.channelObject[0]
          if(channelUser.name == userName.value && channelNames.indexOf(channelObject.name) == -1) {
            channelList.value.push(channelObject)
          }
        })
      }
    })

    /**
     * チャンネルを更新した時のブロードキャスト受信
     */
    window.Echo.channel("update-channel").listen('.ChannelEvent', result => {
      const channel = result.channelObject

      channelList.value.filter(targetChannel => {
        if (targetChannel.id == channel.id) {
          targetChannel.description = channel.description
        }
      })
    })

    /**
     * リアクションの更新処理
     * @param {array} messages メッセージ一覧
     * @param {object} reaction リアクション
     */
    const reactionUpdate = (messages, reaction) => {
      messages.filter(function (message) {
        // 更新したリアクションのメッセージIDと同じメッセージ
        if (message.id == reaction.message_id) {
          // リアクション一覧を追加または更新する
          let isUpdate = false
          message.reactions.filter(function (targetReaction) {
            if (targetReaction.id == reaction.id) {
              targetReaction.number += 1
              isUpdate = true
            }
          })
          if (isUpdate === false) {
            message.reactions.push(reaction)
          }
        }
      })
    }

    /**
     * リアクションを更新した時のブロードキャスト受信
     */
    window.Echo.channel("update-reaction").listen('.ReactionEvent', result => {
      const reaction = result.reaction

      if (result.isThreadMessage) {
        reactionUpdate(threadModal.value.threadMessages, reaction)
      } else {
        reactionUpdate(messages.value, reaction)
      }
    })

    /**
     * メンションを作成した時のブロードキャスト受信
     */
    window.Echo.channel("create-mention").listen('.MentionEvent', result => {
      if (Push.Permission.has() && result.userId == userId.value) {
        Push.create('メッセージが届きました。', { body: result.message, icon: result.speakerImagePath })
      }
    })

    return {
      userId,
      userName,
      email,
      userCount,
      showLoading,
      showAddMember,
      showAddMemberSuccess,
      showAddChannel,
      showAddChannelSuccess,
      showChannelDetail,
      showEditChannelDescription,
      showAddChannelMember,
      sendInvitationMail,
      updateEmail,
      addChannel,
      fetchChannels,
      messages,
      channelList,
      channelName,
      channelDescription,
      channelCreateUser,
      channelUsers,
      channelAddUsers,
      notChannelUsers,
      isChannelTab,
      isChannelPublic,
      isChannelUpdate,
      selectChannel,
      messageListArea,
      reactionMessage,
      threadMessage,
      changeChannel,
      updateAddChannelName,
      updateAddChannelDescription,
      updateAddChannelIsPrivate,
      updateChannelDescription,
      updateDescription,
      addChannelName,
      addChannelDescription,
      addChannelIsPrivate,
      isShowEmojiPicker,
      isShowCenterEmojiPicker,
      isShowMentionMember,
      isShowThread,
      selectMentionUsers,
      mentionMemberModal,
      deleteMentionUser,
      inputEmoji,
      reactionEmoji,
      chatInputArea,
      threadMessageParam,
      threadModal,
      chatMessages,
      updateAreaReaction,
      addChannelModal,
      addMemberModal,
      channelAddMemberModal
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
.list-enter-active,
.list-leave-active {
  transition: opacity 0.5s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
}
</style>
