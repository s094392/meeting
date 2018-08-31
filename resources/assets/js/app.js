import './bootstrap';
import Vue from 'vue'
import Vuex from 'vuex';
import router from './router'
import App from './App'

Vue.prototype.$meetingStatus = Object.freeze({
  Initialize: 1,
  Start: 2,
  End: 3,
  RecordComplete: 4,
  Archive: 5
});

Vue.prototype.$meetingStatusText = Object.freeze([
  "",
  "會議初始化",
  "會議開始",
  "會議結束",
  "會議記錄完成",
  "會議封存"
]);

Vue.use(Vuex);
const store = new Vuex.Store({
  state: {
    user: {}
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    }
  }
});

const app = new Vue({
  el: '#app',
  components: { App },
  store,
  router,
});
