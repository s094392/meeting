<template>
<div uk-grid v-if="meeting">
  <div class="uk-width-3-4@l">
    <h2>{{ meeting.title }}</h2>
    <div class="uk-card uk-card-default uk-card-body uk-card-small">
    
      <ul uk-tab>
        <li :class="{'uk-active': view == 'properties'}" @click="view = 'properties'">
          <router-link :to="{name:'detail', params: {id: id, view: 'properties'}}" replace="">
            <span class="uk-text-large uk-text-lead">會議資料</span>
          </router-link>
        </li>
        <li :class="{'uk-active': view == 'attendees'}" @click="view = 'attendees'">
          <router-link :to="{name:'detail', params: {id: id, view: 'attendees'}}" replace="">
            <span class="uk-text-large uk-text-lead">參與人員</span>
          </router-link >
        </li>
        <li :class="{'uk-active': view == 'record'}" @click="view = 'record'">
          <router-link :to="{name:'detail', params: {id: id, view: 'record'}}" replace="">
            <span class="uk-text-large uk-text-lead">會議內容</span>
          </router-link >
        </li>
      </ul>

      <span>
        <div v-show="view == 'properties'">
          <Properties :meeting="meeting"/>
          <MeetingControl :meeting="meeting" :me="me" @updateMe="updateMe" v-if="attendees"
          @startMeeting="startMeeting" @endMeeting="endMeeting"/>
        </div>
        <Attendees v-if="attendees" v-show="view == 'attendees'" :meeting="meeting" :attendees="attendees" @updateAttendee="updateAttendee"/>
        <Record v-if="attendees" v-show="view == 'record'" :meeting="meeting"/>
      </span>
    </div>
  </div>

  <div class="uk-width-1-4@l" :class="{'visibility-hidden': view != 'record'}">
    <h4>目錄</h4>
    <div class="uk-card uk-card-small uk-card-default uk-card-body" uk-sticky="offset:40;" id="toc"></div>
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
import Properties from "./Properties";
import Attendees from "./Attendees";
import Record from "./Record";
import MeetingControl from "../Shared/MeetingControl";
import { mapState } from "vuex";

export default {
  created() {
    this.init();
  },
  computed: {
    me: {
      get: function() {
        return this.attendees.find(
          attendees => attendees.user_id === this.user.user_id
        );
      },
      set: function(me) {
        let index = this.attendees.findIndex(
          attendees => attendees.user_id === this.user.user_id
        );
        this.$set(this.attendees, index, me);
      }
    },
    ...mapState(["user"])
  },
  data: function() {
    return {
      id: this.$route.params.id,
      view: this.$route.params.view,
      meeting: null,
      attendees: null
    };
  },
  components: {
    Properties,
    Attendees,
    Record,
    MeetingControl
  },
  methods: {
    init: function() {
      axios.get("/api/meeting/" + this.id).then(response => {
        this.meeting = response.data;
      });
      axios
        .get(`/api/attendee/meeting_id/${this.id}/user_id`)
        .then(response => {
          this.attendees = response.data;
        });
    },
    updateMe: function(me) {
      this.me = me;
    },
    updateAttendee: function(modifiedAttendee) {
      let index = this.attendees.findIndex(
        attendee => attendee.user_id === modifiedAttendee.user_id
      );
      this.$set(this.attendees, index, modifiedAttendee);
    },
    startMeeting: function(meeting) {
      this.meeting = meeting;
      console.log(meeting);
    },
    endMeeting: function(meeting) {
      this.meeting = meeting;
    }
  }
};
</script>
