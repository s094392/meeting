import './bootstrap';
import Vue from 'vue';
import router from './router';
import store from './store';
import App from './App';
import BASE_PATH from './base_path';

Vue.prototype.$meetingStatus = Object.freeze({
  Init: 1,
  Start: 2,
  End: 3,
  RecordComplete: 4,
  Archive: 5,
});

Vue.prototype.$meetingStatusText = Object.freeze([
  '',
  '新會議',
  '進行中',
  '等待舉辦人確認',
  '會議記錄完成',
  '已報帳封存',
]);

Vue.prototype.$attendeeStatus = Object.freeze({
  Absent: 1,
  LateOrLeaveEarly: 2,
  OnTime: 3,
});

Vue.prototype.$basePath = BASE_PATH;

export default new Vue({
  el: '#app',
  components: { App },
  store,
  router,
});
