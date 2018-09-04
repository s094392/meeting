import Vue from 'vue'
import Vuex from 'vuex';

Vue.use(Vuex);
export default new Vuex.Store({
  state: {
    user: {}
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    }
  },
  actions: {
    initUser({ commit }) {
      return new Promise((resolve, reject) => {
        axios.get("/api/me").then(response => {
          commit('setUser', response.data)
          resolve();
        })
      })
    }
  }
});
