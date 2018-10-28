import Vue from 'vue';
import VueRouter from 'vue-router';
import isEmpty from 'lodash/isEmpty';

import Home from './components/Home/Root';
import MeetingList from './components/MeetingList/Root';
import MeetingDetail from './components/MeetingDetail/Root';
import Properties from './components/MeetingDetail/Properties';
import Attendees from './components/MeetingDetail/Attendees';
import Record from './components/MeetingDetail/Record';
import Profile from './components/Profile/Root';
import ProfileRedirect from './components/Profile/ProfileRedirect';
import MeetingEditor from './components/Shared/MeetingEditor';
import PageNotFound from './components/Shared/PageNotFound';
import Manual from './components/Manual';
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
      path: '/detail/:id',
      name: 'detail',
      component: MeetingDetail,
      children: [
        {
          path: '',
          redirect: { name: 'properties' },
          meta: { title: '會議資料' },
        },
        {
          path: 'properties',
          name: 'properties',
          component: Properties,
          meta: { title: '會議資料' },
        },
        {
          path: 'attendees',
          name: 'attendees',
          component: Attendees,
        },
        {
          path: 'record',
          name: 'record',
          component: Record,
        },
      ],
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
      meta: { title: '個人報表' },
      component: ProfileRedirect,
    },
    {
      path: '*',
      name: '404',
      meta: { title: '404' },
      component: PageNotFound,
    },
    {
      path: '/manual',
      name: 'manual',
      meta: { title: '使用手冊' },
      component: Manual,
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

function inDetailPage(name) {
  const names = ['properties', 'attendees', 'record'];
  return names.indexOf(name) !== -1;
}

router.beforeEach((to, from, next) => {
  store.commit('startLoad');
  checkIfInit().then(() => {
    next();
    // dont update title when switching tab in detail page
    if (!(inDetailPage(from.name) && inDetailPage(to.name))) {
      document.title = `${to.meta.title} - Meeting`;
    }
  });
});

router.afterEach(() => store.commit('endLoad'));

export default router;
