import axios from 'axios'

export const FetchChannel = async () => {
  let channels = null
  await axios.get('/api/channels').then((result) => {
    channels = result
  })
  return channels.data
}

export const CountChannelUsers = async (channelId) => {
  let count = null
  await axios.get('/api/channels/user_count', {
    params: {
      'channel_id': channelId,
    }
  }).then((result) => {
    count = result.data
  })
  return count
}
