import axios from 'axios';

export const SendInvitationMail = async (email, password) => {
  let sentEmail = false;
  await axios.post('/api/mail/invitation', {
    'email': email,
    'password': password,
  }).then((result) => {
    if (result.status === 200) {
      sentEmail = true;
    }
  })

  return sentEmail;
}
