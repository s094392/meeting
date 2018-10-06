<template>
<div v-if="me && isOwnerOrAttendee && meeting.status <= $meetingStatus.End">
  <div class="buttons uk-display-inline-block">
    <div >
      <span v-if="meeting.owner_id === user.user_id">
        <button v-if="meeting.status === $meetingStatus.Init" @click="startMeeting"
                class="uk-button uk-button-default uk-button-primary">開始</button>
        <button v-if="meeting.status === $meetingStatus.Init"
                class="uk-button uk-button-default">取消</button>
        <div class="confirm-drop" uk-drop="mode: click; offset: 5; pos: bottom-center">
          <div class="uk-card uk-card-body uk-card-default uk-card-small deep-shadow">
            <span>確定取消會議？</span>
            <button class="uk-button uk-button-danger uk-button-small"
                    @click="cancelMeeting">確定</button>
          </div>
        </div>
        <button v-if="meeting.status === $meetingStatus.Start" type="button" @click="endMeeting"
        class="uk-button uk-button-default uk-button-primary">結束</button>
        <button v-if="meeting.status === $meetingStatus.End" type="button" @click="completeRecord"
        class="uk-button uk-button-default uk-button-primary">確認會議紀錄</button>
        <router-link :to="{name: 'edit', params: {id: meeting.id}}"
                     class="uk-button uk-button-default">編輯</router-link>
      </span>
      <span v-if="meeting.status === $meetingStatus.Init && isAttendee">
        <button class="uk-button uk-button-default uk-button-primary"
                v-if="!me.absent_reason" type="button">請假</button>
          <div uk-dropdown="mode: click;" v-if="!me.absent_reason">
            <ul class="uk-nav uk-dropdown-nav">
              <li class="uk-nav-header">請假原因</li>
              <li><a href="#" @click="changeAbsentReason('值班')">值班</a></li>
              <li><a href="#" @click="changeAbsentReason('實習')">實習</a></li>
              <li><a href="#" @click="changeAbsentReason('回家')">回家</a></li>
              <li><a href="#" @click="changeAbsentReason('大考')">大考</a></li>
              <li class="uk-nav-divider"></li>
              <li><a href="#" :uk-toggle="`target: #absent-${meeting.id}`">其他</a></li>
            </ul>
          </div>
        <button class="uk-button uk-button-default"
                v-if="me.absent_reason"
                @click="changeAbsentReason(null)" type="button">取消請假</button>
        <button class="uk-button uk-button-default"
                v-if="!me.late_reason"
                :uk-toggle="`target: #late-${meeting.id}`" type="button">遲到報備</button>
        <button class="uk-button uk-button-default"
                v-else type="button" @click="changeLate(true)">取消遲到報備</button>
        <button class="uk-button uk-button-default"
                v-if="!me.leave_early_reason"
                :uk-toggle="`target: #leave-early-${meeting.id}`" type="button">早退報備</button>
        <button class="uk-button uk-button-default"
                v-else type="button" @click="changeLeaveEarly(true)">取消早退報備</button>
      </span>
    </div>
  </div>

  <div v-if="meeting.status === $meetingStatus.Init && isAttendee"
       :id="`absent-${meeting.id}`"  uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">請假</h2>
        <form @submit.prevent class="uk-form-stacked">
          <div class="uk-margin">
            <textarea class="uk-textarea" rows="5"
                   type="text" v-model="reason" placeholder="給個原因..."></textarea>
          </div>
          <div class="uk-margin">
            <button class="uk-modal-close uk-button uk-button-primary"
                    type="button" @click="changeAbsentReason()">送出</button>
          </div>
        </form>
    </div>
  </div>

  <div v-if="meeting.status === $meetingStatus.Init && isAttendee"
       :id="`late-${meeting.id}`" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">遲到報備</h2>
        <form @submit.prevent class="uk-form-stacked">
          <div class="uk-margin">
            <textarea class="uk-textarea" rows="5"
                      v-model="reason" placeholder="給個原因..."></textarea>
          </div>
          <div class="uk-margin">
            <button class="uk-modal-close uk-button uk-button-primary"
                    type="button" @click="changeLate()">送出</button>
          </div>
        </form>
    </div>
  </div>

  <div :id="`leave-early-${meeting.id}`" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">早退報備</h2>
        <form @submit.prevent class="uk-form-stacked">
          <div class="uk-margin">
            <textarea class="uk-textarea" rows="5"
                   v-model="reason" placeholder="給個原因..."></textarea>
          </div>
          <div class="uk-margin">
            <button class="uk-modal-close uk-button uk-button-primary"
                    type="button" @click="changeLeaveEarly()">送出</button>
          </div>
        </form>
    </div>
  </div>
</div>
</template>

<style lang="scss" scoped>
.buttons {
  white-space: nowrap;
  width: 100%;
  overflow: auto;
}
.confirm-drop {
  width: auto;
}
</style>

<script>
import { mapState } from 'vuex';
import moment from 'moment';
import isEmpty from 'lodash/isEmpty';
import uniq from 'lodash/uniq';

export default {
  computed: {
    isAttendee() {
      return !isEmpty(this.me) && this.meeting.owner_id !== this.user.user_id;
    },
    isOwnerOrAttendee() {
      return !isEmpty(this.me) || this.meeting.owner_id === this.user.user_id;
    },
    ...mapState(['user', 'editRecord']),
  },
  props: ['meeting', 'me', 'id'],
  data() {
    return {
      reason: '',
    };
  },
  methods: {
    startMeeting() {
      axios.post(`/api/meetings/start/${this.meeting.id}`).then((response) => {
        this.$emit('startMeeting', response.data);
      });
    },
    endMeeting() {
      axios.post(`/api/meetings/end/${this.meeting.id}`).then((response) => {
        this.$emit('endMeeting', response.data);
      });
    },
    put(data) {
      axios
        .put(
          `/api/attendees/meeting_id/${this.meeting.id}/`
          + `user_id/${this.user.user_id}`, data,
        )
        .then((response) => {
          this.$emit('updateMe', response.data);
          this.reason = '';
        });
    },
    changeLate(clear) {
      if (!this.reason && !clear) return;
      this.put({
        late_reason: this.reason,
      });
    },
    changeLeaveEarly(clear) {
      if (!this.reason && !clear) return;
      this.put({
        leave_early_reason: this.reason,
      });
    },
    changeAbsentReason(reason) {
      this.put({
        absent_reason: reason,
      });
    },
    completeRecord() {
      if (this.editRecord) {
        UIkit.modal.alert('會議紀錄尚未儲存<br>請儲存後重試');
        return;
      }
      const meetingStart = moment(this.meeting.start_time);
      const meetingEnd = moment(this.meeting.end_time);
      let bad = [];
      this.meeting.attendees.forEach((attendee) => {
        if (attendee.arrive_time
            && !moment(attendee.arrive_time).isBetween(meetingStart, meetingEnd)) {
          bad.push(attendee.username);
        }
        if (attendee.leave_time
            && !moment(attendee.leave_time).isBetween(meetingStart, meetingEnd)) {
          bad.push(attendee.username);
        }
      });
      if (bad) {
        bad = uniq(bad);
        const alertString = `以下人員的資料有誤<br>${bad.toString()}<br>請檢查該成員的遲到/早退時間是否介於會議的開始/結束時間`;
        UIkit.modal.alert(alertString);
      } else {
        axios
          .put(`/api/meetings/${this.meeting.id}`, {
            status: this.$meetingStatus.RecordComplete,
          })
          .then((response) => {
            this.$emit('completeRecord', response.data);
          });
      }
    },
    cancelMeeting() {
      axios.delete(`/api/meetings/${this.meeting.id}`).then(() => this.$emit('cancelMeeting'));
    },
  },
};
</script>
