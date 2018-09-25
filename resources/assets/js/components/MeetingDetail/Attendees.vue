<template>
<div style="margin-bottom: 40px;">
  <div v-if="meeting.status >= $meetingStatus.Start" class="uk-width-1-1 section-title">
    <span class="uk-text-large uk-text-lead">已到成員</span>
  </div>
  <span v-for="member in present" :key="member.user_id"
    @click="changePresent(member.user_id, false)" class="name-tag" :class="{clickable: canModify}">
    {{ member.username }}
  </span>
  <div v-if="absent.length + absentWithReason.length  ||
             meeting.status === $meetingStatus.Start" uk-grid>
    <div class="uk-width-1-2@s">
    <div class="uk-width-1-1 section-title">
      <span class="uk-text-large uk-text-lead">
        <span v-if="meeting.status >= $meetingStatus.Start">未到成員</span>
        <span v-else>參與成員</span>
      </span>
    </div>
    <span v-for="member in absent" :key="member.user_id"
      @click="changePresent(member.user_id, true)" class="name-tag" :class="{clickable: canModify}">
      {{ member.username }}
    </span>
    </div>

      <div class="uk-width-1-2@s">
      <div class="section-title">
        <span class="uk-text-large uk-text-lead">請假成員</span>
      </div>
      <div class="uk-overflow-auto">
        <table class="uk-table uk-table-responsive uk-table-divider uk-table-small">
          <tbody>
            <tr v-for="member in absentWithReason" v-bind:key="'off-'+member.user_id">
              <td class="td-id">{{ member.username }}</td>
              <td class="uk-table-expand">{{ member.absent_reason }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div v-if="late.length + leaveEarly.length ||
             meeting.status === $meetingStatus.Start"  uk-grid>
    <div class="uk-width-1-2@s">
      <div class="uk-width-1-1 section-title">
        <span class="uk-text-large uk-text-lead">遲到成員</span>
        <button v-if="canModify" class="uk-button uk-button-default uk-button-small"
                type="button" uk-toggle="target: #add-late">
          <span uk-icon="plus"></span>
          新增
        </button>
      </div>
      <div class="uk-overflow-auto uk-width-1-1">
        <table class="uk-table uk-table-divider uk-table-small">
          <tbody>
          <tr v-for="member in late" v-bind:key="'late-'+member.user_id">
            <td class="td-id">
          <tr>{{ member.username }}</tr>
          <tr class="monospace">
            <span>{{ removeSecond(member.arrive_time) }}</span>
            <span class="cursor-pointer" v-if="canModify"
                  uk-icon="icon: pencil; ratio: 0.7" @click="setTempTime(member.arrive_time)">
            </span>
            <div v-if="canModify" uk-drop="mode: click; offset: 5; pos: bottom-center"
                 class="time-setter">
              <div class="uk-card uk-card-body uk-card-default uk-card-small time-set-card">
                <div class="uk-align-right button-edit-submit" >
                  <a href="#" class="uk-button uk-button-primary uk-button-small"
                     @click="addLate(member.user_id, temp_time, null)">確定</a>
                </div>
                <label>抵達時間</label>
                <input type="time" class="uk-input" v-model="temp_time"
                       pattern="[0-23]{2}:[0-59]{2}" placeholder="HH:mm">
              </div>
            </div>
          </tr>
          </td>
          <td class="td-reason pre-wrap">{{ member.late_reason }}</td>
          <td v-if="canModify">
            <span class="uk-icon-button" uk-icon="icon: close; ratio: 0.7"
                  @click="removeLate(member.user_id)"></span>
          </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="uk-width-1-2@s">
      <div class="uk-width-1-1 section-title">
        <span class="uk-text-large uk-text-lead">早退成員</span>
        <button v-if="canModify" class="uk-button uk-button-default uk-button-small"
                type="button" uk-toggle="target: #add-leave-early">
          <span uk-icon="plus"></span>
          新增
        </button>
      </div>
      <div class="uk-overflow-auto">
        <table class="uk-table uk-table-divider uk-table-small">
          <tbody>
          <tr v-for="member in leaveEarly" v-bind:key="'leave-early-'+member.user_id">
            <td class="td-id">
              <tr>{{ member.username }}</tr>
              <tr class="monospace">
                <span>{{ removeSecond(member.leave_time) }}</span>
                <span class="cursor-pointer" v-if="canModify"
                      uk-icon="icon: pencil; ratio: 0.7" @click="setTempTime(member.leave_time)">
                </span>
                <div v-if="canModify" uk-drop="mode: click; offset: 5; pos: bottom-center"
                     class="time-setter">
                  <div class="uk-card uk-card-body uk-card-default uk-card-small time-set-card">
                    <div class="uk-align-right button-edit-submit" >
                      <a href="#" class="uk-button uk-button-primary uk-button-small"
                         @click="addLeaveEarly(member.user_id, temp_time, null)">確定</a>
                    </div>
                    <label>離開時間</label>
                    <input type="time" class="uk-input" v-model="temp_time"
                           pattern="[0-23]{2}:[0-59]{2}" placeholder="HH:mm">
                  </div>
                </div>
              </tr>
            </td>
            <td class="td-reason pre-wrap">{{ member.leave_early_reason }}</td>
            <td v-if="canModify">
              <span class="uk-icon-button" uk-icon="icon: close; ratio: 0.7"
                @click="removeLeaveEarly(member.user_id)"></span>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
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
.uk-icon-button {
  width: 21px;
  height: 21px;
  cursor: pointer;
  float: right;
  margin-bottom: 3px;
  background: #fff;
}
.uk-icon-button:hover {
  background: #ddd;
  transition: all 0.3s ease-in-out;
}
.td-id {
  width: 100px;
}
.td-reason {
  word-break: break-word;
}
.button-edit-submit {
  margin-bottom: 5px;
  margin-left: 0;
}
.time-setter {
  width: 200px;
}
.time-set-card {
  -webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
}
</style>


<script>
import { mapState } from 'vuex';
import AttendeeAdder from './AttendeeAdder';

export default {
  props: ['meeting', 'attendees'],
  components: {
    AttendeeAdder,
  },
  computed: {
    canModify() {
      return (
        this.meeting.status <= this.$meetingStatus.End
        && this.meeting.status !== this.$meetingStatus.Init
        && this.meeting.owner === this.user.user_id
      );
    },
    present() {
      return this.attendees.filter(attendee => attendee.status > this.$attendeeStatus.Absent);
    },
    absent() {
      return this.attendees.filter(attendee => attendee.status === this.$attendeeStatus.Absent);
    },
    absentWithReason() {
      return this.attendees.filter(attendee => attendee.absent_reason
          && attendee.status === this.$attendeeStatus.Absent);
    },
    leaveEarly() {
      return _.orderBy(this.attendees.filter(
        attendee => attendee.leave_early_reason || attendee.leave_time,
      ), 'leave_time', 'desc');
    },
    late() {
      return _.orderBy(this.attendees.filter(
        attendee => attendee.late_reason || attendee.arrive_time,
      ), 'arrive_time', 'desc');
    },
    ...mapState(['user']),
  },
  data() {
    return {
      temp_time: '',
    };
  },
  methods: {
    setTempTime(time) {
      if (time) this.temp_time = this.removeSecond(time);
      else {
        const now = new Date();
        const hour = `0${now.getHours()}`.slice(-2);
        const min = `0${now.getMinutes()}`.slice(-2);
        this.temp_time = `${hour}:${min}`;
      }
    },
    updateAttendee(userId, data) {
      if (!this.canModify) return;
      axios
        .put(
          `/api/attendee/meeting_id/${this.meeting.id}/user_id/${userId}`,
          data,
        )
        .then((response) => {
          this.$emit('updateAttendee', response.data);
        });
    },
    changePresent(userId, present) {
      this.updateAttendee(userId, {
        status: present ? this.$attendeeStatus.OnTime : this.$attendeeStatus.Absent,
      });
    },
    addLate(userId, time, reason) {
      const data = {
        status: this.$attendeeStatus.LateOrLeaveEarly,
        arrive_time: time,
      };
      if (reason) data.late_reason = reason;
      this.updateAttendee(userId, data);
    },
    addLeaveEarly(userId, time, reason) {
      const data = {
        status: this.$attendeeStatus.LateOrLeaveEarly,
        leave_time: time,
      };
      if (reason) data.leave_early_reason = reason;
      this.updateAttendee(userId, data);
    },
    removeLate(userId) {
      this.updateAttendee(userId, {
        status: this.$attendeeStatus.OnTime,
        arrive_time: null,
        late_reason: null,
      });
    },
    removeLeaveEarly(userId) {
      this.updateAttendee(userId, {
        status: this.$attendeeStatus.OnTime,
        leave_time: null,
        leave_early_reason: null,
      });
    },
    removeSecond(s) {
      if (!s) return '--:--';
      return s
        .split(':')
        .splice(0, 2)
        .join(':');
    },
  },
};
</script>
