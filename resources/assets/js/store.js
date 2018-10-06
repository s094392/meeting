import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
export default new Vuex.Store({
  state: {
    user: {},
    loading: true,
  },
  /* eslint-disable no-param-reassign */
  mutations: {
    setUser(state, user) {
      state.user = user;
      state.user.user_id = parseInt(state.user.user_id, 10);
    },
    startLoad(state) {
      state.loading = true;
    },
    endLoad(state) {
      state.loading = false;
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
