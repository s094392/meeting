import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import ActiveMeetings from './components/ActiveMeetings'
import InactiveMeetings from './components/InactiveMeetings'
import MeetingList from './components/MeetingList'
import MeetingFilter from './components/MeetingFilter'
import MeetingDetail from './components/MeetingDetail'
import Toc from './components/Toc'

export default new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: '/',
      components: {
        main: ActiveMeetings,
        right: InactiveMeetings
      }
    },
    {
      path: '/list',
      name: 'list',
      components: {
        main: MeetingList,
        right: MeetingFilter
      }
    },
    {
      path: '/detail',
      name: 'detail',
      components: {
        main: MeetingDetail,
        right: Toc
      }
    }
  ]
})
