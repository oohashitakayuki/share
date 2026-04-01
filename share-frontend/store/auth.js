export const state = () => ({
  user: null,
  initialized: false
})

export const mutations = {
  setUser(state, user) {
    state.user = user
  },
  setInitialized(state, value) {
    state.initialized = value
  }

}