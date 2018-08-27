<template>
<div uk-grid>
  <div class="uk-width-3-4@l">
    <h2>WWW 新生訓練 - 點名</h2>
    <div class="uk-card uk-card-default uk-card-body uk-card-small">
      <h3>已到成員</h3>
      <span class="name-tag clickable " :class="{'disabled': member.loading}"
            v-for="(member, idx) in presentAttendees" :key="member.id" @click="toAbsent(idx)" v-if="member">
        {{member.user_id}}
      </span>
      <h3>未到成員</h3>
      <span class="name-tag clickable" :class="{'disabled': member.loading}"
            v-for="(member, idx) in absentAttendees" :key="member.id" @click="toPresent(idx)" v-if="member">
        {{member.user_id}}
      </span>
      <h3>請假成員</h3>
      <span class="name-tag"
            v-for="member in onLeaveAttendees" :key="member.id" v-if="member" disabled>
        {{member.user_id}}
      </span>
      <br>
      <button @click="startMeeting" class="uk-button uk-button-default uk-button-primary uk-margin-large" >會議開始</button>
    </div>
  </div>
</div>
</template>

<script>
export default {
  data: function() {
    return {
      presentAttendees: [],
      absentAttendees: [],
      onLeaveAttendees: [],
      meetingId: this.$route.params.id,
      promises: []
    };
  },
  created() {
    this.fetchAttendees();
  },
  methods: {
    fetchAttendees: function() {
      axios
        .get(`/api/attendee/meeting_id/${this.meetingId}/user_id`)
        .then(response => {
          this.presentAttendees = response.data.filter(
            attendee => attendee.status == "OnTime"
          );
          this.absentAttendees = response.data.filter(
            attendee => attendee.status == "Initialized"
          );
          this.onLeaveAttendees = response.data.filter(
            attendee => attendee.status == "RequestedLeave"
          );
        });
    },
    toAbsent: function(idx) {
      var user_id = this.presentAttendees[idx].user_id;
      this.$set(this.presentAttendees[idx], "loading", true);
      this.promises.push(
        axios
          .put(
            `/api/attendee/meeting_id/${this.meetingId}/user_id/${user_id}`,
            {
              status: "Initialized"
            }
          )
          .then(() => {
            this.absentAttendees.push(this.presentAttendees[idx]);
            this.$set(this.presentAttendees[idx], "loading", false);
            this.presentAttendees.splice(idx, 1);
          })
      );
    },
    toPresent: function(idx) {
      var user_id = this.absentAttendees[idx].user_id;
      this.$set(this.absentAttendees[idx], "loading", true);
      this.promises.push(
        axios
          .put(
            `/api/attendee/meeting_id/${this.meetingId}/user_id/${user_id}`,
            {
              status: "OnTime"
            }
          )
          .then(() => {
            this.presentAttendees.push(this.absentAttendees[idx]);
            this.$set(this.absentAttendees[idx], "loading", false);
            this.absentAttendees.splice(idx, 1);
          })
      );
    },
    startMeeting: function() {
      this.promises.push(
        axios.put(`/api/meeting/${this.meetingId}`, {
          status: "Started"
        })
      );
      axios.all(this.promises).then(() => {
        this.$router.push({
          name: "detail",
          params: { id: this.meetingId, view: "record" }
        });
      });
    }
  }
};
</script>
