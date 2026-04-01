import { auth } from '~/plugins/firebase'

export default ({ store }) => {

  auth.onAuthStateChanged(user => {

    if (user) {
      store.commit('auth/setUser', {
        uid: user.uid,
        email: user.email,
        name: user.displayName
      })
    } else {
      store.commit('auth/setUser', null)
    }

    store.commit('auth/setInitialized', true)
  })

}