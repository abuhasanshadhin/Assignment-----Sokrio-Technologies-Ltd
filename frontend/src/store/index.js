import { createStore } from 'vuex'
import attendance from './attendance'
import auth from './auth'
import branch from './branch'
import user from './user'

export default createStore({
  state: {
  },
  mutations: {
  },
  actions: {
  },
  modules: {
    auth,
    branch,
    user,
    attendance
  }
})
