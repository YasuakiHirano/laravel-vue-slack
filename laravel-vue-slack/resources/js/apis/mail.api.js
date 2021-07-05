import axios from 'axios';

export const SendInvitationMail = async (email) => {
  let sentEmail = false;
  await axios.post('/api/mail/invitation', {
    'email': email
  }).then((result) => {
    if (result.status === 200) {
      sentEmail = true;
    }
  })

  return sentEmail;
}
