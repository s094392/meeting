<template>
<div>
  <div>
    <h3>準時成員</h3>
    <span v-for="attendee in onTime" :key="attendee.user_id" class="name-tag" >{{ attendee.user_id }}</span>
    <h3>遲到成員</h3>
    <span v-for="attendee in late" :key="attendee.user_id" class="name-tag" >{{ attendee.user_id }}</span>
    <h3>早退成員</h3>
    <span v-for="attendee in leaveEarly" :key="attendee.user_id" class="name-tag" >{{ attendee.user_id }}</span>
    <AttendeeAdder :attendeeOptions="onTime.map(a => a.user_id)" :status="'LeaveEarly'" @selected="changeStatus"/>
    <h3>請假成員</h3>
    <span v-for="attendee in onLeave" :key="attendee.user_id" class="name-tag" >{{ attendee.user_id }}</span>
    <h3>未到成員</h3>
    <span v-for="attendee in absent" :key="attendee.user_id" class="name-tag" >{{ attendee.user_id }}</span>
    <h3>翹咪成員</h3>
    <span v-for="attendee in cut" :key="attendee.user_id" class="name-tag" >{{ attendee.user_id }}</span>
  </div>

</div>
</template>



<script>
import AttendeeAdder from "./AttendeeAdder";

export default {
  created() {
    this.fetchAttendees();
  },
  data() {
    return {
      onTime: [],
      late: [],
      leaveEarly: [],
      onLeave: [],
      absent: [],
      cut: [],
      id: this.$route.params.id
    };
  },
  components: {
    AttendeeAdder
  },
  methods: {
    fetchAttendees: function() {
      var self = this;
      axios
        .get(`/api/attendee/meeting_id/${self.id}/user_id`)
        .then(response => {
          this.onTime = response.data.filter(
            attendee => attendee.status == "OnTime"
          );
          this.leaveEarly = response.data.filter(
            attendee => attendee.status == "LeaveEarly"
          );
          this.absent = response.data.filter(
            attendee => attendee.status == "Initialized"
          );
          this.cut = response.data.filter(attendee => attendee.status == "Cut");
        });
    },
    changeStatus: function(status, attendee, time) {
      axios
        .put(`/api/attendee/meeting_id/${this.id}/user_id/${attendee}`, {
          status: status
        })
        .then(response => {
          _.remove(this.onTime, a => a.user_id === attendee);
          this.leaveEarly.push(response.data);
        });
    }
  }
};
</script>
