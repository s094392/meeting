import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './components/Home/Root';
import MeetingList from './components/MeetingList/Root';
import MeetingDetail from './components/MeetingDetail/Root';
import MeetingEditor from './components/Shared/MeetingEditor';
import BATH_PATH from './base_path';

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
  // dont update title when switching tab in detail page
  if (!(to.name === 'detail' && from.name === 'detail')) {
    document.title = `${to.meta.title} - Meeting`;
  }
  next();
});

export default router;
