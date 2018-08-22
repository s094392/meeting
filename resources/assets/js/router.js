import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Home from './components/Home/Root'
import MeetingList from './components/MeetingList/Root'
import MeetingDetail from './components/MeetingDetail/Root'
import CheckIn from './components/CheckIn'
import CreateMeeting from './components/CreateMeeting'

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
      path: '/checkin/:id',
      name: 'checkin',
      component: CheckIn
    },
    {
      path: '/create',
      name: 'create',
      component: CreateMeeting
    }
  ],
  scrollBehavior(to, from, savedPosition) {
    return { x: 0, y: 0 }
  }

})
