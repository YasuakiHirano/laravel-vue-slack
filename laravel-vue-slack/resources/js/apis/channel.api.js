import axios from 'axios'

export const FetchChannel = async () => {
  let channels = null
  await axios.get('/api/channels').then((result) => {
    channels = result
  })
  return channels.data
}
