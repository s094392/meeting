<template>
<div>
  <div class="uk-card uk-card-default uk-card-body uk-margin-top">
    <div>
      <router-link :to="{name:'detail', params: {id: meeting.id, view: 'properties'}}" class="uk-card-title">{{ meeting.title }}</router-link>
      <span v-if="me"  class="uk-label uk-align-right">你的會議</span>
    </div>
    <p>
      <span class="uk-margin-small-right" uk-icon="user" />{{ meeting.owner }}<br>
      <span class="uk-margin-small-right" uk-icon="tag" />{{ meeting.group }}<br>
      <span class="uk-margin-small-right" uk-icon="clock" />{{ meeting.scheduled_time }}
    </p>
    <p>{{ meeting.description }}<br></p>
    <MeetingControl :meeting="meeting" :me="me" @updateMe="updateMe" v-on:delete="$emit('delete', meeting.id);" 
      @startMeeting="startMeeting" @endMeeting="endMeeting"/>
  </div>
</div>
</template>


<script>
import MeetingControl from "../Shared/MeetingControl";
import { mapState } from "vuex";

export default {
  computed: mapState(["user"]),
  props: ["meeting"],
  components: {
    MeetingControl
  },
  data() {
    return {
      me: null
    };
  },
  created() {
    this.fetchUser();
  },
  methods: {
    fetchUser: function() {
      axios
        .get(
          `/api/attendee/meeting_id/${this.meeting.id}/user_id/${
            this.user.user_id
          }`
        )
        .then(response => {
          this.me = response.data;
        });
    },
    updateMe: function(me) {
      this.me = me;
    },
    startMeeting: function(meeting) {
      this.$router.push({
        name: "detail",
        params: { id: meeting.id, view: "attendees" }
      });
    },
    endMeeting: function(meeting) {
      this.$router.push({
        name: "detail",
        params: { id: meeting.id, view: "record" }
      });
    }
  }
};
</script>
