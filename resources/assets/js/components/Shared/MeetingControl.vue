<template>
<div v-if="me">
	<div class="buttons uk-display-inline-block">
		<div v-if="meeting.status==this.$meetingStatus.Initialize" >
      <span v-if="meeting.owner === user.user_id">
        <button @click="startMeeting"  
          class="uk-button uk-button-default uk-button-primary">開始</button>
        <router-link :to="{name: 'edit', params: {id: meeting.id}}"   class="uk-button uk-button-default">編輯</router-link>
        <button v-on:click="$emit('delete')" class="uk-button uk-button-default">取消</button>
      </span>
			<button class="uk-button uk-button-default" v-if="!me.absent_reason" type="button">請假</button>
				<div uk-dropdown="mode: click;" v-if="!me.absent_reason">
					<ul class="uk-nav uk-dropdown-nav">
						<li class="uk-nav-header">請假原因</li>
						<li><a href="#" @click="changeAbsentReason('值班')">值班</a></li>
						<li><a href="#" @click="changeAbsentReason('實習')">實習</a></li>
						<li><a href="#" @click="changeAbsentReason('回家')">回家</a></li>
						<li><a href="#" @click="changeAbsentReason('大考')">大考</a></li>
						<li class="uk-nav-divider"></li>
						<li><a href="#" uk-toggle="target: #absent">其他</a></li>
					</ul>
				</div>
			<button class="uk-button uk-button-default" v-if="me.absent_reason" @click="changeAbsentReason(null)" type="button" >取消請假</button>
			<button class="uk-button uk-button-default" v-if="!me.estimate_arrive_time" uk-toggle="target: #late" type="button">遲到報備</button>
      <button class="uk-button uk-button-default" v-else type="button" @click="changeLate(true)">取消遲到報備</button>
			<button class="uk-button uk-button-default" v-if="!me.estimate_leave_time" uk-toggle="target: #leave-early" type="button">早退報備</button>
      <button class="uk-button uk-button-default" v-else type="button" @click="changeLeaveEarly(true)">取消早退報備</button>
		</div>
		<div v-if="meeting.status==this.$meetingStatus.Start && meeting.owner === user.user_id" >
			<button class="uk-button uk-button-default uk-button-primary" type="button">結束</button>
		</div>
	</div>

  <div id="absent" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">請假原因？</h2>
        <form @submit.prevent>
          <div class="uk-margin">
            <input class="uk-input" id="form-stacked-text" type="text" v-model="reason" placeholder="Some text...">
          </div>
          <div class="uk-margin">
            <button class="uk-modal-close uk-button uk-button-primary" type="button" @click="changeAbsentReason()">送出</button>
          </div>
        </form>
    </div>
  </div>

  <div id="late" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">遲到報備</h2>
        <form @submit.prevent class="uk-form-stacked">
          <label class="uk-form-label" for="form-stacked-text">原因</label>
          <div class="uk-margin">
            <input class="uk-input" id="form-stacked-text" type="text" v-model="reason" placeholder="Some text...">
          </div>
          <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">預計到達時間</label>
            <input class="uk-input" id="form-stacked-text" type="time" v-model="time" placeholder="Some text...">
          </div>
          <div class="uk-margin">
            <button class="uk-modal-close uk-button uk-button-primary" type="button" @click="changeLate()">送出</button>
          </div>
        </form>
    </div>
  </div>

  <div id="leave-early" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">早退報備</h2>
        <form @submit.prevent class="uk-form-stacked">
          <label class="uk-form-label" for="form-stacked-text">原因</label>
          <div class="uk-margin">
            <input class="uk-input" id="form-stacked-text" type="text" v-model="reason" placeholder="Some text...">
          </div>
          <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">預計離開時間</label>
            <input class="uk-input" id="form-stacked-text" type="time" v-model="time" placeholder="Some text...">
          </div>
          <div class="uk-margin">
            <button class="uk-modal-close uk-button uk-button-primary" type="button" @click="changeLeaveEarly()">送出</button>
          </div>
        </form>
    </div>
  </div>
</div>
</template>

<style lang="scss">
.buttons {
  white-space: nowrap;
  width: 100%;
  overflow: auto;
}
</style>

<script>
import { mapState } from "vuex";

export default {
  computed: mapState(["user"]),
  props: ["meeting", "me"],
  data() {
    return {
      reason: "",
      time: ""
    };
  },
  methods: {
    startMeeting: function() {
      axios
        .put(`/api/meeting/${this.meeting.id}`, {
          status: this.$meetingStatus.Start
        })
        .then(() => {
          this.$router.push({
            name: "detail",
            params: { id: this.meeting.id, view: "attendees" }
          });
        });
    },
    changeLate: function(clear) {
      if (!this.time && !clear) return;
      axios
        .put(
          `/api/attendee/meeting_id/${this.meeting.id}/user_id/${
            this.user.user_id
          }`,
          {
            estimate_arrive_time: this.time,
            late_reason: this.reason
          }
        )
        .then(response => {
          this.$emit("updateMe", response.data);
        });
      this.time = null;
      this.reason = "";
    },
    changeLeaveEarly: function(clear) {
      if (!this.time && !clear) return;
      axios
        .put(
          `/api/attendee/meeting_id/${this.meeting.id}/user_id/${
            this.user.user_id
          }`,
          {
            estimate_leave_time: this.time,
            leave_early_reason: this.reason
          }
        )
        .then(response => {
          this.$emit("updateMe", response.data);
        });
      this.time = null;
      this.reason = "";
    },
    changeAbsentReason: function(reason) {
      if (!reason) {
        reason = this.reason;
      }
      axios
        .put(
          `/api/attendee/meeting_id/${this.meeting.id}/user_id/${
            this.user.user_id
          }`,
          {
            absent_reason: reason
          }
        )
        .then(response => {
          this.$emit("updateMe", response.data);
          this.time = null;
          this.reason = "";
        });
    }
  }
};
</script>
