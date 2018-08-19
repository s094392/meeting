import './bootstrap';
import Vue from 'vue'
import router from './router'
import App from './App'

const app = new Vue({
  el: '#app',
  components: { App },
  router,
});
