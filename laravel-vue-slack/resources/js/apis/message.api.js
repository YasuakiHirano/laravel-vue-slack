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

export const UpdateMessage = async (messageId, content) => {
    let updated = false
    await axios.put('/api/messages', {
      'message_id': messageId,
      'content': content
    }).then((result) => {
      if (result.status === 200) {
        updated = true
      }
    })
    return updated
  }

export const DeleteMessage = async (messageId) => {
    let deleted = false
    await axios.delete('/api/messages', {
      params: {
        'message_id': messageId,
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
    console.log(messages.data)
    return messages.data
}
