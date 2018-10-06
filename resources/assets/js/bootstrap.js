
import Icons from 'uikit/dist/js/uikit-icons';
import BASE_PATH from './base_path';

window.UIkit = require('uikit');

UIkit.use(Icons);

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

const token = document.head.querySelector('meta[name="csrf-token"]');
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

axios.defaults.baseURL = BASE_PATH;

axios.interceptors.response.use(null, (error) => {
  if (error.response.status === 403 || error.response.status === 419) {
    return window.location.assign(`${window.location}?expired=true`);
  }
  return Promise.reject(error);
});
