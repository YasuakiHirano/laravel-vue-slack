import axios from 'axios'

export const CreateMessage = async (channelId, content, userId, mentionUsers, parentMessageId) => {
  let created = false
  await axios.post('/api/messages', {
    'channel_id': channelId,
    'content': content,
    'create_user_id': userId,
    'mention_users': mentionUsers,
    'parent_message_id': parentMessageId,
  }).then((result) => {
    if (result.status === 200) {
      created = true
    }
  })
  return created
}

export const UpdateMessage = async (messageId, content, channelId) => {
    let updated = false
    await axios.put('/api/messages', {
      'message_id': messageId,
      'content': content,
      'channel_id': channelId,
    }).then((result) => {
      if (result.status === 200) {
        updated = true
      }
    })
    return updated
  }

export const DeleteMessage = async (messageId, channelId) => {
    let deleted = false
    await axios.delete('/api/messages', {
      params: {
        'message_id': messageId,
        'channel_id': channelId,
      }
    }).then((result) => {
      deleted = true
    })
    return deleted
}

export const FetchMessages = async (channelId) => {
    let messages = null
    await axios.get('/api/messages', {
      params: {
        'channel_id': channelId,
      }
    }).then((result) => {
      messages = result
    })
    return messages.data
}

export const FetchThreadMessages = async (messageId) => {
    let messages = null
    await axios.get('/api/messages/' + messageId).then((result) => {
      messages = result
    })
    return messages.data
}
