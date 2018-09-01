<template>
<div>
	<div class="buttons uk-display-inline-block">
		<div v-if="meeting.status==this.$meetingStatus.Initialize" >
			<button @click="startMeeting"  
				class="uk-button uk-button-default uk-button-primary">開始</button>
			<router-link :to="{name: 'edit', params: {id: meeting.id}}"   class="uk-button uk-button-default">編輯</router-link>
			<button v-on:click="$emit('delete')" class="uk-button uk-button-default">取消</button>
			<button class="uk-button uk-button-default" v-show="!attendee.absent_reason" type="button">請假</button>
				<div uk-dropdown="mode: click;" v-show="!attendee.absent_reason">
					<ul class="uk-nav uk-dropdown-nav">
						<li class="uk-nav-header">請假原因</li>
						<li><a href="#" @click="changeAbsentReason('值班')">值班</a></li>
						<li><a href="#" @click="changeAbsentReason('實習')">實習</a></li>
						<li><a href="#" @click="changeAbsentReason('回家')">回家</a></li>
						<li><a href="#" @click="changeAbsentReason('大考')">大考</a></li>
						<li class="uk-nav-divider"></li>
						<li><a href="#">其他</a></li>
					</ul>
				</div>
			<button class="uk-button uk-button-default" v-show="attendee.absent_reason" @click="changeAbsentReason(null)" type="button" >取消請假</button>
			<button class="uk-button uk-button-default" type="button">遲到報備</button>
			<button class="uk-button uk-button-default" type="button">早退報備</button>
		</div>
		<div v-if="meeting.status==this.$meetingStatus.Start" >
			<button class="uk-button uk-button-default uk-button-primary" type="button">結束</button>
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
  props: ["meeting"],
  created() {
    this.fetchUser();
  },
  data() {
    return {
      attendee: {}
    };
  },
  methods: {
    fetchUser: function() {
      axios
        .get(
          `/api/attendee/meeting_id/${this.meeting.id}/user_id/${this.user.uid}`
        )
        .then(response => {
          this.attendee = response.data;
        });
    },
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
    changeAbsentReason: function(reason) {
      axios
        .put(
          `/api/attendee/meeting_id/${this.meeting.id}/user_id/${
            this.user.uid
          }`,
          {
            absent_reason: reason
          }
        )
        .then(response => {
          this.attendee = response.data;
        });
    }
  }
};
</script>
