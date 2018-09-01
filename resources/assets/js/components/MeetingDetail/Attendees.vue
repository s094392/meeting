<template>
<div>
  <div class="uk-width-1-1 section-title">
    <span class="uk-text-large uk-text-lead">已到成員</span>
  </div>
  <span v-for="(member, idx) in present" :key="member.user_id" 
    @click="toAbsents(idx)" class="name-tag clickable" >
    {{ member.user_id }}
  </span>

  <div class="uk-width-1-1 section-title">
    <span class="uk-text-large uk-text-lead">未到成員</span>
  </div>
  <span v-for="(member, idx) in absent" :key="member.user_id" 
    @click="toPresents(idx)" class="name-tag clickable" >
    {{ member.user_id }}
  </span>

  <div class="uk-width-1-1 section-title">
    <span class="uk-text-large uk-text-lead">遲到成員</span>
    <button class="uk-button uk-button-default uk-button-small add-button" type="button" uk-toggle="target: #add-late">
      <span uk-icon="plus"></span>
      新增
    </button>
  </div>
        
  <div class="uk-overflow-auto uk-width-1-1">
    <table class="uk-table uk-table-responsive uk-table-divider uk-table-small uk-table-middle">
      <thead>
        <tr>
          <th class="remove-th"></th>
          <th>ID</th>
          <th>預計到達</th>
          <th>實際到達</th>
          <th>原因</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="member in late" v-bind:key="member.id">
          <td><span class="uk-icon-button" uk-icon="icon: close; ratio: 0.8" @click="removeLate(member.user_id)"></span></td>
          <td>{{ member.user_id }}</td>
          <td>{{ member.estimate_arrive_time }}</td>
          <td>{{ member.arrive_time }}</td>
          <td>{{ member.late_reason }}</td>
        </tr>
      </tbody>
    </table>
  </div>

   <div class="uk-width-1-1 section-title">
    <span class="uk-text-large uk-text-lead">早退成員</span>
    <button class="uk-button uk-button-default uk-button-small add-button" type="button" uk-toggle="target: #add-leave-early">
      <span uk-icon="plus"></span>
      新增
    </button>
  </div>
  <div class="uk-overflow-auto">
    <table class="uk-table uk-table-responsive uk-table-divider uk-table-small">
      <thead>
        <tr>
          <th class="remove-th"></th>
          <th>ID</th>
          <th>預計離開</th>
          <th>實際離開</th>
          <th>原因</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="member in leaveEarly" v-bind:key="member.id">
          <td><span class="uk-icon-button" uk-icon="icon: close; ratio: 0.8" @click="removeLeaveEarly(member.user_id)"></span></td>
          <td>{{ member.user_id }}</td>
          <td>{{ member.estimate_leave_time }}</td>
          <td>{{ member.leave_time }}</td>
          <td>{{ member.leave_early_reason }}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="uk-width-1-1 section-title">
    <span class="uk-text-large uk-text-lead">請假成員</span>
  </div>
  <div class="uk-overflow-auto">
    <table class="uk-table uk-table-responsive uk-table-divider uk-table-small">
      <thead>
        <tr>
          <th>ID</th>
          <th>原因</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="member in dayoff" v-bind:key="member.id">
          <td>{{ member.user_id }}</td>
          <td>{{ member.absent_reason }}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div id="add-late" uk-modal>
    <AttendeeAdder :attendees="attendees" :type="'late'" @selected="addLate"/>
  </div>

  <div id="add-leave-early" uk-modal>
    <AttendeeAdder :attendees="attendees" :type="'leaveEarly'" @selected="addLeaveEarly"/>
  </div>
</div>
</template>

<style lang="scss" scoped>
.section-title {
  margin-top: 40px;
  margin-bottom: 5px;
}
.add-button {
  margin-bottom: 8px;
}
.uk-icon-button {
  width: 27px;
  height: 27px;
  cursor: pointer;
  float: right;
}
.remove-th {
  width: 0px;
}
.uk-table-small th {
  padding-top: 0px;
}
</style>


<script>
import AttendeeAdder from "./AttendeeAdder";

export default {
  components: {
    AttendeeAdder
  },
  data() {
    return {
      attendees: [],
      present: [],
      absent: [],
      dayoff: [],
      leaveEarly: [],
      late: [],
      meetingId: this.$route.params.id
    };
  },
  methods: {
    fetchAttendees: function() {
      axios
        .get(`/api/attendee/meeting_id/${this.meetingId}/user_id`)
        .then(response => {
          this.attendees = response.data;
          this.present = response.data.filter(
            attendee => attendee.present == "1"
          );
          this.absent = response.data.filter(
            attendee => attendee.present == "0"
          );
          this.dayoff = response.data.filter(
            attendee => attendee.absent_reason
          );
          this.leaveEarly = response.data.filter(
            attendee => attendee.estimate_leave_time || attendee.leave_time
          );
          this.late = response.data.filter(
            attendee => attendee.estimate_arrive_time || attendee.arrive_time
          );
        });
    },
    toAbsents: function(idx) {
      let user_id = this.present[idx].user_id;
      axios
        .put(`/api/attendee/meeting_id/${this.meetingId}/user_id/${user_id}`, {
          present: false
        })
        .then(() => {
          this.absent.push(this.present[idx]);
          this.present.splice(idx, 1);
        });
    },
    toPresents: function(idx) {
      let user_id = this.absent[idx].user_id;
      axios
        .put(`/api/attendee/meeting_id/${this.meetingId}/user_id/${user_id}`, {
          present: true
        })
        .then(() => {
          this.present.push(this.absent[idx]);
          this.absent.splice(idx, 1);
        });
    },
    addLate: function(attendee, time, reason) {
      axios
        .put(`/api/attendee/meeting_id/${this.meetingId}/user_id/${attendee}`, {
          present: true,
          arrive_time: time,
          late_reason: reason
        })
        .then(response => {
          if (!_.includes(this.present, attendee)) {
            this.present.push(response.data);
          }
          this.late.push(response.data);
        });
    },
    addLeaveEarly: function(attendee, time, reason) {
      axios
        .put(`/api/attendee/meeting_id/${this.meetingId}/user_id/${attendee}`, {
          present: true,
          leave_time: time,
          leave_early_reason: reason
        })
        .then(response => {
          if (!_.includes(this.present, attendee)) {
            this.present.push(response.data);
          }
          this.leaveEarly.push(response.data);
        });
    },
    removeLate: function(userId) {
      axios
        .put(`/api/attendee/meeting_id/${this.meetingId}/user_id/${userId}`, {
          arrive_time: null,
          late_reason: null,
          estimate_arrive_time: null
        })
        .then(() => {
          this.late = _.remove(this.late, a => a.user_id != userId);
        });
    },
    removeLeaveEarly: function(userId) {
      axios
        .put(`/api/attendee/meeting_id/${this.meetingId}/user_id/${userId}`, {
          leave_time: null,
          leave_early_reason: null,
          estimate_leave_time: null
        })
        .then(() => {
          this.leaveEarly = _.remove(this.leaveEarly, a => a.user_id != userId);
        });
    }
  },
  created() {
    this.fetchAttendees();
  }
};
</script>
