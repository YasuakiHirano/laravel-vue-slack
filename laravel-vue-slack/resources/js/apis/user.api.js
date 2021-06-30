import axios from 'axios'

export const FindUser = async () => {
  let user = null
  await axios.get('/api/user').then((result) => {
    user = result
  })
  return user.data
}