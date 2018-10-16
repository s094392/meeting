import Vue from 'vue';
import VueRouter from 'vue-router';
import isEmpty from 'lodash/isEmpty';

import Home from './components/Home/Root';
import MeetingList from './components/MeetingList/Root';
import MeetingDetail from './components/MeetingDetail/Root';
import Profile from './components/Profile/Root';
import ProfileRedirect from './components/Profile/ProfileRedirect';
import MeetingEditor from './components/Shared/MeetingEditor';
import PageNotFound from './components/Shared/PageNotFound';
import BATH_PATH from './base_path';
import store from './store';

Vue.use(VueRouter);

const router = new VueRouter({
  base: BATH_PATH,
  mode: 'history',
  routes: [
    {
      path: '/',
      name: '/',
      component: Home,
      meta: { title: '首頁' },
    },
    {
      path: '/list',
      name: 'list',
      component: MeetingList,
      meta: { title: '會議列表' },
    },
    {
      path: '/detail/:id/:view',
      name: 'detail',
      component: MeetingDetail,
      meta: { title: '會議資料' },
    },
    {
      path: '/detail/:id',
      redirect: to => ({
        name: 'detail',
        params: {
          id: to.params.id,
          view: 'properties',
        },
      }),
    },
    {
      path: '/create',
      name: 'create',
      component: MeetingEditor,
      meta: { title: '新建會議' },
    },
    {
      path: '/edit/:id',
      name: 'edit',
      meta: { title: '編輯會議' },
      component: MeetingEditor,
    },
    {
      path: '/profile/:userId/:year/:month',
      name: 'profile',
      meta: { title: '個人報表' },
      component: Profile,
    },
    {
      path: '/profile',
      name: 'profileRedirect',
      component: ProfileRedirect,
    },
    {
      path: '*',
      name: '404',
      meta: { title: '404' },
      component: PageNotFound,
    },
  ],
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return { selector: to.hash };
    }
    if (savedPosition) {
      return savedPosition;
    }
    return { x: 0, y: 0 };
  },
});

function checkIfInit() {
  return new Promise((resolve) => {
    if (isEmpty(store.state.user)) {
      store.dispatch('initUser').then(() => resolve());
    } else {
      resolve();
    }
  });
}

router.beforeEach((to, from, next) => {
  store.commit('startLoad');
  checkIfInit().then(() => {
    next();
    // dont update title when switching tab in detail page
    if (!(to.name === 'detail' && from.name === 'detail')) {
      document.title = `${to.meta.title} - Meeting`;
    }
  });
});

router.afterEach(() => store.commit('endLoad'));

export default router;
