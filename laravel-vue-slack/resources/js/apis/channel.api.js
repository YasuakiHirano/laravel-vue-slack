import axios from 'axios'

export const CreateChannel = async (name, description, isPrivate) => {
  let created = false
  await axios.post('/api/channels', {
    'name': name,
    'description': description,
    'is_private': isPrivate
  }).then((result) => {
    if (result.status === 200) {
      created = true
    }
  })
  return created
}

export const FetchChannel = async () => {
  let channels = null
  await axios.get('/api/channels').then((result) => {
    channels = result
  })
  return channels.data
}

export const UpdateChannel = async (id, name, description, isPublic) => {
  let updated = false
  await axios.put('/api/channels', {
    'id': id,
    'name': name,
    'description': description,
    'is_public': isPublic
  }).then((result) => {
    if (result.status === 200) {
      updated = true
    }
  })
  return updated
}

export const DeleteChannel = async (channelId) => {
    let deleted = false
    await axios.delete('/api/channels', {
      params: {
        'channel_id': channelId,
      }
    }).then((result) => {
      deleted = true
    })
    return deleted
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
