import axios from 'axios'

export const CreateOrUpdateReaction = async (messageId, userId, iconCode, icon) => {
  let createdOrUpdate = false
  await axios.post('/api/reaction', {
    'message_id': messageId,
    'reaction_user_id': userId,
    'icon_code': iconCode,
    'icon': icon
  }).then((result) => {
    if (result.status === 200) {
      createdOrUpdate = true
    }
  })
  return createdOrUpdate
}
