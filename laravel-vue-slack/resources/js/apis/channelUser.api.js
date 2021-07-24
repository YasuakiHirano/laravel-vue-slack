import axios from 'axios'

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
