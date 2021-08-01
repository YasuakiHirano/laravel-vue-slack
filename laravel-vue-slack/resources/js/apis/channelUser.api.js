import axios from 'axios'

export const CreateChannelUsers = async (channelId, userIds) => {
  let created = false
  await axios.post('/api/channel_users', {
    'channel_id': channelId,
    'user_ids': userIds,
  }).then((result) => {
    if (result.status === 200) {
      created = true
    }
  })
  return created
}

export const FetchChannelUsers = async (channelId) => {
  let channelUsers = null
  await axios.get('/api/channel_users', {
      params: {
        'channel_id': channelId,
      }
    }).then((result) => {
      channelUsers = result
    })
  return channelUsers.data
}

export const FetchNotChannelUsers = async (channelId) => {
  let channelUsers = null
  await axios.get('/api/channel_users/not_channel_users', {
      params: {
        'channel_id': channelId,
      }
    }).then((result) => {
      channelUsers = result
    })
  return channelUsers.data
}
