<template>
<div uk-grid v-if="meeting">
  <div class="uk-width-3-4@l">
    <h2>{{ meeting.title }}</h2>
    <div class="uk-card uk-card-default uk-card-body uk-card-small">

      <ul uk-tab>
        <li :class="{'uk-active': view == 'properties'}" @click="view = 'properties'">
          <router-link :to="{name:'detail', params: {id: id, view: 'properties'}}" replace="">
            <span class="uk-text-large">會議資料</span>
          </router-link>
        </li>
        <li :class="{'uk-active': view == 'attendees'}" @click="view = 'attendees'">
          <router-link :to="{name:'detail', params: {id: id, view: 'attendees'}}" replace="">
            <span class="uk-text-large">參與人員</span>
          </router-link >
        </li>
        <li :class="{'uk-active': view == 'record'}" @click="view = 'record'">
          <router-link :to="{name:'detail', params: {id: id, view: 'record'}}" replace="">
            <span class="uk-text-large">會議內容</span>
          </router-link >
        </li>
      </ul>

      <span>
        <div v-show="view == 'properties'">
          <Properties :meeting="meeting"/>
          <MeetingControl :meeting="meeting" :me="me" @updateMe="updateMe"
                          @startMeeting="updateMeeting" @endMeeting="updateMeeting"
                          @completeRecord="updateMeeting" @cancelMeeting="$router.replace('/')"/>
        </div>
        <Attendees v-show="view == 'attendees'"
                  :meeting="meeting" :attendees="meeting.attendees"
                  @updateAttendee="updateAttendee"/>
        <Record v-show="view == 'record'" :meeting="meeting"/>
      </span>
    </div>
  </div>

  <div class="uk-visible@l uk-width-1-4@l" :class="{'visibility-hidden': view != 'record'}">
    <h4>目錄</h4>
    <div class="uk-card uk-card-small uk-card-default uk-card-body"
         uk-sticky="offset:40;" id="toc"></div>
  </div>
</div>
</template>

<style lang="scss">
#toc {
  max-height: 85vh;
  overflow: auto;
}
</style>


<script>
import { mapState } from 'vuex';
import Properties from './Properties';
import Attendees from './Attendees';
import Record from './Record';
import MeetingControl from '../Shared/MeetingControl';

export default {
  beforeRouteEnter(to, from, next) {
    axios.get(`/api/meetings/${to.params.id}`).then((response) => {
      next(vm => vm.setData(response.data));
    }).catch((error) => {
      if (error.response.status === 404) {
        next(vm => vm.redirect404());
      }
    });
  },
  computed: {
    me: {
      get() {
        const me = this.meeting.attendees.find(
          attendees => attendees.user_id === this.user.user_id,
        );
        return me === undefined ? {} : me;
      },
      set(me) {
        const index = this.meeting.attendees.findIndex(
          attendees => attendees.user_id === this.user.user_id,
        );
        this.$set(this.meeting.attendees, index, me);
      },
    },
    ...mapState(['user']),
  },
  data() {
    return {
      id: this.$route.params.id,
      view: this.$route.params.view,
      meeting: undefined,
    };
  },
  components: {
    Properties,
    Attendees,
    Record,
    MeetingControl,
  },
  methods: {
    setData(data) {
      this.meeting = data;
      document.title = `${this.meeting.title} - Meeting`;
    },
    redirect404() {
      this.$router.replace('/404');
    },
    updateMe(me) {
      this.me = me;
    },
    updateAttendee(modifiedAttendee) {
      const index = this.meeting.attendees.findIndex(
        attendee => attendee.user_id === modifiedAttendee.user_id,
      );
      this.$set(this.meeting.attendees, index, modifiedAttendee);
    },
    updateMeeting(meeting) {
      this.meeting = meeting;
    },
  },
};
</script>
