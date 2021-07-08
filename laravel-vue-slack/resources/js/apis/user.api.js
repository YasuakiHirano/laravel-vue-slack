import axios from 'axios'

export const FindUser = async () => {
  let user = null
  await axios.get('/api/user').then((result) => {
    user = result
  })
  return user.data
}

export const CreateUser = async (email, name, password) => {
  let created = false
  await axios.post('/api/user', {
    'email': email,
    'name': name,
    'password': password
  }).then((result) => {
    if (result.status === 200) {
      created = true
    }
  })
  return created
}
