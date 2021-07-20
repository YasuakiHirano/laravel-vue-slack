import axios from 'axios'

export const CreateMessage = async (channelId, content) => {
  let created = false
  await axios.post('/api/messages', {
    'channel_id': channelId,
    'content': content
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
