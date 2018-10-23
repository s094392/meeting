<template>
<div>
  <div class="uk-card uk-card-default uk-card-body uk-margin-top">
    <div>
      <router-link :to="{ name:'properties', params: { id: meeting.id } }"
                   class="uk-card-title">{{ meeting.title }}</router-link>
      <span v-if="isOwnerOrAttendee"  class="uk-label uk-align-right">你的會議</span>
    </div>
    <p>
      <span class="uk-margin-small-right" uk-icon="user" />{{ meeting.owner_name }}<br>
      <span class="uk-margin-small-right" uk-icon="tag" />{{ meeting.group }}<br>
      <span class="uk-margin-small-right" uk-icon="clock" />{{ meeting.scheduled_time }}
    </p>
    <p class="pre-wrap description">{{ meeting.description }}</p>
    <MeetingControl :meeting="meeting" :me.sync="me"
      @cancelMeeting="$emit('cancelMeeting');"
      @startMeeting="startMeeting" @endMeeting="endMeeting"/>
  </div>
</div>
</template>

<style lang="scss" scoped>
.description {
  max-height: 100px;
  overflow: hidden;
}
</style>


<script>
import { mapState } from 'vuex';
import isEmpty from 'lodash/isEmpty';
import MeetingControl from '../Shared/MeetingControl';

export default {
  computed: {
    isOwnerOrAttendee() {
      return !isEmpty(this.me);
    },
    ...mapState(['user']),
  },
  props: ['meeting'],
  components: {
    MeetingControl,
  },
  data() {
    return {
      me: null,
    };
  },
  created() {
    this.fetchUser();
  },
  methods: {
    fetchUser() {
      axios
        .get(
          `/api/attendees/meeting_id/${this.meeting.id}/`
          + `user_id/${this.user.user_id}`,
        )
        .then((response) => {
          this.me = response.data ? response.data : {};
        });
    },
    startMeeting(meeting) {
      this.$router.push({
        name: 'properties',
        params: { id: meeting.id },
      });
    },
    endMeeting(meeting) {
      this.$router.push({
        name: 'properties',
        params: { id: meeting.id },
      });
    },
  },
};
</script>
