import axios from 'axios';

export const UserSignIn = async (email, password) => {
  let signIn = false;
  await axios.post('/api/signin', {
    'email': email,
    'password': password,
  }).then((result) => {
    if (result.status === 200) {
      signIn = true;
    }
  })

  return signIn;
}

export const FetchUsers = () => {
  axios.get('/api/user').then((result) => {
    console.log(result);
  })
}