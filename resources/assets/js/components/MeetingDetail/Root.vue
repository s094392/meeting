<template>
<div uk-grid v-if="meeting">
  <div class="uk-width-3-4@l">
    <span class="page-title">{{ meeting.title }}</span>
    <div class="uk-card uk-card-default uk-card-body uk-card-small">

      <ul uk-tab>
        <li :class="{'uk-active': view === 'properties'}">
          <router-link :to="{name:'detail', params: {id: id, view: 'properties'}}" replace="">
            <span class="uk-text-large"><span class="uk-visible@s">會議</span>資料</span>
          </router-link>
        </li>
        <li :class="{'uk-active': view === 'attendees'}">
          <router-link :to="{name:'detail', params: {id: id, view: 'attendees'}}" replace="">
            <span class="uk-text-large"><span class="uk-visible@s">參與</span>人員</span>
          </router-link >
        </li>
        <li :class="{'uk-active': view === 'record'}">
          <router-link :to="{name:'detail', params: {id: id, view: 'record'}}" replace="">
            <span class="uk-text-large"><span class="uk-visible@s">會議</span>紀錄</span>
          </router-link >
        </li>
      </ul>

      <span>
        <div v-show="view === 'properties'">
          <Properties :meeting="meeting"/>
          <MeetingControl :meeting="meeting" :me="me" @updateMe="updateMe"
                          :editingRecord="editingRecord" @cancelMeeting="$router.replace('/')"
                          @startMeeting="updateMeeting" @endMeeting="updateMeeting"
                          @completeRecord="updateMeeting" />
        </div>
        <Attendees v-show="view === 'attendees'"
                  :meeting="meeting" :attendees="meeting.attendees"
                  @updateAttendee="updateAttendee"/>
        <Record v-show="view === 'record'" :meeting="meeting" :editingRecord="editingRecord"
                @startEdit="editingRecord = true" @endEdit="editingRecord = false"/>
      </span>
    </div>
  </div>

  <div class="uk-visible@l uk-width-1-4@l" :class="{'visibility-hidden': view !== 'record'}">
    <h4>目錄</h4>
    <div class="uk-card uk-card-small uk-card-default uk-card-body"
         uk-sticky="offset:40;" id="toc"></div>
  </div>
</div>
</template>

<style lang="scss">
#toc {
  max-height: 90vh;
  overflow: auto;
  padding: 20px 10px;
}
.markdownIt-TOC {
  ul {
    padding-left: 15px;
  }
}
@media only screen and (max-width: 640px) {
  .uk-card-small.uk-card-body {
    padding: 15px;
  }
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
  beforeRouteLeave(to, from, next) {
    if (this.editingRecord) {
      UIkit.modal.confirm('會議紀錄尚未完成，是否確定要離開？').then(() => {
        localStorage.removeItem(`${this.meeting.id}_record`);
        next();
      }, () => {
        this.$router.push({ name: 'detail', params: { id: this.id, view: 'record' } });
      });
    } else {
      next();
    }
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
    view() {
      return this.$route.params.view;
    },
    id() {
      return this.$route.params.id;
    },
    ...mapState(['user']),
  },
  data() {
    return {
      meeting: null,
      editingRecord: false,
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
