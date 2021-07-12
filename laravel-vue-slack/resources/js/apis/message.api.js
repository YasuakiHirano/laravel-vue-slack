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
