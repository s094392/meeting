<template>
<div>
  <div class="uk-width-1-1 section-title">
    <span class="uk-text-large uk-text-lead">已到成員</span>
  </div>
  <span v-for="member in present" :key="member.user_id" 
    @click="changePresent(member.user_id, false)" class="name-tag" :class="{clickable: canModify}">
    {{ member.username }}
  </span>

  <div class="uk-width-1-1 section-title">
    <span class="uk-text-large uk-text-lead">未到成員</span>
  </div>
  <span v-for="member in absent" :key="member.user_id" 
    @click="changePresent(member.user_id, true)" class="name-tag" :class="{clickable: canModify}">
    {{ member.username }}
  </span>

  <div class="uk-width-1-1 section-title">
    <span class="uk-text-large uk-text-lead">遲到成員</span>
    <button v-if="canModify" class="uk-button uk-button-default uk-button-small add-button" type="button" uk-toggle="target: #add-late">
      <span uk-icon="plus"></span>
      新增
    </button>
  </div>
        
  <div class="uk-overflow-auto uk-width-1-1">
    <table class="uk-table uk-table-responsive uk-table-divider uk-table-small uk-table-middle">
      <thead>
        <tr>
          <th class="remove-th"  v-if="canModify"></th>
          <th>ID</th>
          <th>預計到達</th>
          <th>實際到達</th>
          <th>原因</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="member in late" v-bind:key="'late-'+member.user_id">
          <td v-if="canModify"><span class="uk-icon-button" uk-icon="icon: close; ratio: 0.8" @click="removeLate(member.user_id)"></span></td>
          <td>{{ member.username }}</td>
          <td>{{ removeSecond(member.estimate_arrive_time) }}</td>
          <td>{{ removeSecond(member.arrive_time) }}</td>
          <td>{{ member.late_reason }}</td>
        </tr>
      </tbody>
    </table>
  </div>

   <div class="uk-width-1-1 section-title">
    <span class="uk-text-large uk-text-lead">早退成員</span>
    <button v-if="canModify" class="uk-button uk-button-default uk-button-small add-button" type="button" uk-toggle="target: #add-leave-early">
      <span uk-icon="plus"></span>
      新增
    </button>
  </div>
  <div class="uk-overflow-auto">
    <table class="uk-table uk-table-responsive uk-table-divider uk-table-small">
      <thead>
        <tr>
          <th class="remove-th" v-if="canModify"></th>
          <th>ID</th>
          <th>預計離開</th>
          <th>實際離開</th>
          <th>原因</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="member in leaveEarly" v-bind:key="'leaveEarly-'+member.user_id">
          <td v-if="canModify"><span class="uk-icon-button" uk-icon="icon: close; ratio: 0.8" @click="removeLeaveEarly(member.user_id)"></span></td>
          <td>{{ member.username }}</td>
          <td>{{ removeSecond(member.estimate_leave_time) }}</td>
          <td>{{ removeSecond(member.leave_time) }}</td>
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
        <tr v-for="member in dayoff" v-bind:key="'off-'+member.user_id">
          <td>{{ member.username }}</td>
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
import { mapState } from "vuex";

export default {
  props: ["meeting", "attendees"],
  components: {
    AttendeeAdder
  },
  computed: {
    canModify: function() {
      return (
        this.meeting.status != this.$meetingStatus.Archive &&
        this.meeting.status != this.$meetingStatus.Initialize &&
        this.meeting.owner == this.user.user_id
      );
    },
    present: function() {
      return this.attendees.filter(attendee => attendee.present == "1");
    },
    absent: function() {
      return this.attendees.filter(attendee => attendee.present == "0");
    },
    dayoff: function() {
      return this.attendees.filter(attendee => attendee.absent_reason);
    },
    leaveEarly: function() {
      return this.attendees.filter(
        attendee => attendee.estimate_leave_time || attendee.leave_time
      );
    },
    late: function() {
      return this.attendees.filter(
        attendee => attendee.estimate_arrive_time || attendee.arrive_time
      );
    },
    ...mapState(["user"])
  },
  data() {
    return {};
  },
  methods: {
    updateAttendee: function(userId, data) {
      if (!this.canModify) return;
      axios
        .put(
          `/api/attendee/meeting_id/${this.meeting.id}/user_id/${userId}`,
          data
        )
        .then(response => {
          this.$emit("updateAttendee", response.data);
        });
    },
    changePresent: function(userId, present) {
      this.updateAttendee(userId, {
        present: present
      });
    },
    addLate: function(userId, time, reason) {
      this.updateAttendee(userId, {
        present: true,
        arrive_time: time,
        late_reason: reason
      });
    },
    addLeaveEarly: function(userId, time, reason) {
      this.updateAttendee(userId, {
        present: true,
        leave_time: time,
        leave_early_reason: reason
      });
    },
    removeLate: function(userId) {
      this.updateAttendee(userId, {
        arrive_time: null,
        late_reason: null,
        estimate_arrive_time: null
      });
    },
    removeLeaveEarly: function(userId) {
      this.updateAttendee(userId, {
        leave_time: null,
        leave_early_reason: null,
        estimate_leave_time: null
      });
    },
    removeSecond: function(s) {
      if (!s) return s;
      return s
        .split(":")
        .splice(0, 2)
        .join(":");
    }
  }
};
</script>
