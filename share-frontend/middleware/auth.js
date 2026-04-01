export default async ({ store, redirect }) => {

  while (!store.state.auth.initialized) {
    await new Promise(resolve => setTimeout(resolve, 50))
  }

  if (!store.state.auth.user) {
    return redirect('/login')
  }

}