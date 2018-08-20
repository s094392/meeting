import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Home from './components/Home'
import MeetingList from './components/MeetingList'
import MeetingDetail from './components/MeetingDetail'
import CheckIn from './components/CheckIn'
import NewMeeting from './components/NewMeeting'

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
      path: '/checkin',
      name: 'checkin',
      component: CheckIn
    },
    {
      path: '/new',
      name: 'new',
      component: NewMeeting
    }
  ]
})
