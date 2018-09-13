import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
export default new Vuex.Store({
  state: {
    user: {},
  },
  /* eslint-disable no-param-reassign */
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
  },
  actions: {
    initUser({ commit }) {
      return new Promise((resolve) => {
        axios.get('/api/me').then((response) => {
          commit('setUser', response.data);
          resolve();
        });
      });
    },
  },
});
