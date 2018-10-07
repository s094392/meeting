<template>
<div class="uk-margin-bottom">
  <div class="uk-margin-medium-bottom uk-width-1-1" v-if="meeting.status >= $meetingStatus.Start">
    <div class=" section-title">已到成員</div>
    <span v-for="member in present" :key="member.user_id"
      @click="changePresent(member.user_id, false)" class="name-tag"
      :class="{clickable: canModify}">
      {{ member.username }}
    </span>
    </div>
  <div v-if="absent.length + absentWithReason.length || canModify" uk-grid>
    <div class="uk-width-1-2@s uk-margin-medium-bottom">
    <div class="uk-width-1-1 section-title">
      <span>
        <span v-if="meeting.status >= $meetingStatus.Start">未到成員</span>
        <span v-else>參與成員</span>
      </span>
    </div>
    <span v-for="member in absent" :key="member.user_id"
      @click="changePresent(member.user_id, true)" class="name-tag" :class="{clickable: canModify}">
      {{ member.username }}
    </span>
    </div>
      <div class="uk-width-1-2@s uk-margin-medium-bottom">
      <div class="section-title">
        <span>請假成員</span>
      </div>
      <div class="uk-overflow-auto">
        <table class="uk-table uk-table-divider uk-table-small">
          <tbody>
            <tr v-for="member in absentWithReason" v-bind:key="'off-'+member.user_id">
              <td class="td-id">{{ member.username }}</td>
              <td class="uk-table-expand">{{ member.absent_reason | showReason }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div v-if="late.length + leaveEarly.length || canModify"  uk-grid>
    <div class="uk-width-1-2@s uk-margin-medium-bottom">
      <div class="uk-width-1-1 section-title">
        <span>遲到成員</span>
        <button v-if="canModify" class="uk-button uk-button-default uk-button-small"
                @click="showLateModal(null)" type="button">
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
              <tr>
                <span :uk-tooltip="`title: ${member.arrive_time}; pos: bottom-left`">
                  {{ member.arrive_time | onlyTime }}
                </span>
              </tr>
            </td>
            <td class="td-reason pre-wrap">{{ member.late_reason | showReason }}</td>
            <td v-if="canModify" class="uk-table-shrink">
              <a href='#' uk-icon="icon: close; ratio: 0.9"
                @click="removeLate(member.user_id)"></a>
              <a href='#' uk-icon="icon: pencil; ratio: 0.9"
                @click="showLateModal(member)"></a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="uk-width-1-2@s uk-margin-medium-bottom">
      <div class="uk-width-1-1 section-title">
        <span>早退成員</span>
        <button v-if="canModify" class="uk-button uk-button-default uk-button-small"
                @click="showLeaveEarlyModal(null)" type="button">
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
              <tr>
                <span :uk-tooltip="`title: ${member.leave_time}; pos: bottom-left`">
                  {{ member.leave_time | onlyTime }}
                </span>
              </tr>
            </td>
            <td class="td-reason pre-wrap">{{ member.leave_early_reason }}</td>
            <td v-if="canModify" class="uk-table-shrink">
              <a href='#' uk-icon="icon: close; ratio: 0.9"
                @click="removeLeaveEarly(member.user_id)"></a>
              <a href='#' uk-icon="icon: pencil; ratio: 0.9"
                @click="showLeaveEarlyModal(member)"></a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div ref="late-modal" uk-modal>
    <AttendeeEditor :attendeesOption="attendees" :attendee='editingAttendee'
                    :meeting='meeting' :type="'late'" :mode="attendeeEditorMode"
                    @selected="addLate"/>
  </div>

  <div ref="leave-early-modal" uk-modal>
    <AttendeeEditor :attendeesOption="attendees" :attendee='editingAttendee'
                    :meeting='meeting' :type="'leaveEarly'" :mode="attendeeEditorMode"
                    @selected="addLeaveEarly"/>
  </div>
</div>
</template>

<style lang="scss" scoped>
.section-title {
  margin-bottom: 5px;
  font-size: 1.3rem;
}
.td-id {
  width: 100px;
}
.td-reason {
  word-break: break-word;
}
</style>


<script>
import { mapState } from 'vuex';
import moment from 'moment';
import orderBy from 'lodash/orderBy';
import AttendeeEditor from './AttendeeEditor';

export default {
  props: ['meeting', 'attendees'],
  components: {
    AttendeeEditor,
  },
  computed: {
    canModify() {
      return (
        this.meeting.status <= this.$meetingStatus.End
        && this.meeting.status !== this.$meetingStatus.Init
        && this.meeting.owner_id === this.user.user_id
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
      return orderBy(this.attendees.filter(
        attendee => attendee.leave_early_reason || attendee.leave_time,
      ), 'leave_time', 'desc');
    },
    late() {
      return orderBy(this.attendees.filter(
        attendee => attendee.late_reason || attendee.arrive_time,
      ), 'arrive_time', 'desc');
    },
    ...mapState(['user']),
  },
  data() {
    return {
      editingAttendee: null,
      attendeeEditorMode: 'new',
      flatPickrConfig: {
        enableTime: true,
      },
    };
  },
  methods: {
    showLeaveEarlyModal(attendee) {
      this.editingAttendee = Object.assign({}, attendee);
      this.attendeeEditorMode = attendee ? 'edit' : 'new';
      UIkit.modal(this.$refs['leave-early-modal']).show();
    },
    showLateModal(attendee) {
      this.editingAttendee = Object.assign({}, attendee);
      this.attendeeEditorMode = attendee ? 'edit' : 'new';
      UIkit.modal(this.$refs['late-modal']).show();
    },
    updateAttendee(userId, data) {
      if (!this.canModify) return;
      axios
        .put(
          `/api/attendees/meeting_id/${this.meeting.id}/user_id/${userId}`,
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
  },
  filters: {
    onlyTime(s) {
      if (!s) return '--:--';
      return moment(s).format('HH:mm');
    },
    showReason(r) {
      if (!r) return '未填寫原因';
      return r;
    },
  },
};
</script>
