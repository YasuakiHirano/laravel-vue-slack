import axios from 'axios'

export const CreateOrUpdateReaction = async (messageId, userId, iconCode, icon) => {
  let createdOrUpdated = false
  await axios.post('/api/reaction', {
    'message_id': messageId,
    'reaction_user_id': userId,
    'icon_code': iconCode,
    'icon': icon
  }).then((result) => {
    if (result.status === 200) {
      createdOrUpdated = true
    }
  })
  return createdOrUpdated
}

export const UpdateReactionNumber = async (reactionId, userId) => {
  let updated = false
  await axios.get('/api/reaction/plus', {
    params: {
      'reaction_id': reactionId,
      'user_id': userId,
    }
  }).then((result) => {
    if (result.status === 200) {
      updated = true
    }
  })
  return updated
}
