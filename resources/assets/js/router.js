import Vue from 'vue';
import moment from 'moment';
import VueRouter from 'vue-router';

import Home from './components/Home/Root';
import MeetingList from './components/MeetingList/Root';
import MeetingDetail from './components/MeetingDetail/Root';
import Profile from './components/Profile/Root';
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
      path: '/profile/:year/:month',
      name: 'profile',
      meta: { title: '個人報表' },
      component: Profile,
    },
    {
      path: '/profile',
      name: 'profileRedirect',
      meta: { title: '個人報表' },
      redirect: {
        name: 'profile',
        params: {
          year: moment().get('year'),
          month: moment().get('month') + 1,
        },
      },
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
    } if (savedPosition) {
      return savedPosition;
    }
    return { x: 0, y: 0 };
  },
});


router.beforeEach((to, from, next) => {
  store.commit('startLoad');
  next();
  // dont update title when switching tab in detail page
  if (!(to.name === 'detail' && from.name === 'detail')) {
    document.title = `${to.meta.title} - Meeting`;
  }
});

router.afterEach(() => store.commit('endLoad'));

export default router;
