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
