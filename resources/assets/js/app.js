import './bootstrap';
import Vue from 'vue';
import router from './router';
import store from './store';
import App from './App';
import BASE_PATH from './base_path';
import MeetingEnum from './MeetingEnum';

Object.keys(MeetingEnum).forEach((key) => {
  Vue.prototype[`$${key}`] = MeetingEnum[key];
});

Vue.prototype.$basePath = BASE_PATH;

export default new Vue({
  el: '#app',
  components: { App },
  store,
  router,
});
