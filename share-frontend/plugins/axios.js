import { auth } from '~/plugins/firebase'

export default function ({ $axios }) {

  $axios.interceptors.request.use(async config => {

    const user = auth.currentUser

    if (user) {
      const token = await user.getIdToken()
      config.headers.Authorization = `Bearer ${token}`
    }

    return config
  })

}