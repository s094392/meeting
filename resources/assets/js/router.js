import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Home from './components/Home/Root'
import MeetingList from './components/MeetingList/Root'
import MeetingDetail from './components/MeetingDetail/Root'
import MeetingEditor from './components/Shared/MeetingEditor'

export default new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: '/',
      component: Home
    },
    {
      path: '/list',
      name: 'list',
      component: MeetingList
    },
    {
      path: '/detail/:id/:view',
      name: 'detail',
      component: MeetingDetail
    },
    {
      path: '/create',
      name: 'create',
      component: MeetingEditor
    },
    {
      path: '/edit/:id',
      name: 'edit',
      component: MeetingEditor
    }
  ],
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return { selector: to.hash }
    } else if (savedPosition) {
      return savedPosition;
    } else {
      return { x: 0, y: 0 }
    }
  }
})
