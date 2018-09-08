<template>
<div uk-grid>
  <div class="uk-width-3-4@l">
  <h2 v-if="editMode">編輯會議</h2>
	<h2 v-else>新增會議</h2>
	<div class="uk-card uk-card-default uk-card-body uk-card-small">
	  <form v-on:submit.prevent class="uk-form-horizontal uk-margin-large">

	  <div class="uk-margin">
		<label class="uk-form-label" for="form-horizontal-text">會議名稱</label>
		<div class="uk-form-controls">
		  <input v-model="meeting.title" class="uk-input"
		  :class="{'form-danger': !meeting.title && triedPost}" type="text" placeholder="輸入會議名稱...">
		</div>
	  </div>

	  <div class="uk-margin">
		<label class="uk-form-label" for="form-horizontal-text">會議組別</label>
		<div class="uk-form-controls">
		  <multiselect class="multi-select" v-model="meeting.group" placeholder="選擇會議組別..." 
		  :class="{'form-danger': !meeting.group && triedPost}" :options="groupOptions" ></multiselect>
		</div>
	  </div>

	  <div class="uk-margin" v-if="!editMode || meeting.status == $meetingStatus.Init">
      <label class="uk-form-label" for="form-horizontal-text">預計開會時間</label>
      <div class="uk-form-controls">
        <FlatPickr v-model="meeting.scheduled_time" :config="flatPickrConfig" class="flatpickr-input"
        :class="{'form-danger': !meeting.scheduled_time && triedPost}" placeholder="選擇開會時間..."></FlatPickr>
      </div>
	  </div>

	  <div class="uk-margin" v-if="editMode && meeting.status != $meetingStatus.Archive && meeting.status >= $meetingStatus.Start">
      <label class="uk-form-label" for="form-horizontal-text">開始時間</label>
      <div class="uk-form-controls">
        <FlatPickr v-model="meeting.start_time" :config="flatPickrConfig" class="flatpickr-input"
        :class="{'form-danger': !meeting.start_time && triedPost}" placeholder="選擇開會時間..."></FlatPickr>
      </div>
	  </div>

    <div class="uk-margin" v-if="editMode && meeting.status != $meetingStatus.Archive  && meeting.status >= $meetingStatus.End">
      <label class="uk-form-label" for="form-horizontal-text">結束時間</label>
      <div class="uk-form-controls">
        <FlatPickr v-model="meeting.end_time" :config="flatPickrConfig" class="flatpickr-input"
        :class="{'form-danger': !meeting.end_time && triedPost}" placeholder="選擇開會時間..."></FlatPickr>
      </div>
	  </div>

	  <div class="uk-margin">
		<label class="uk-form-label" for="form-horizontal-text">參與人員</label>
		<div class="uk-form-controls">
		  <Multiselect class="multi-select" v-model="attendees" @input="attendeeSelected" placeholder="選擇參與人員..."
					  :options="attendeeOptions" :hideSelected="true" :multiple="true" :closeOnSelect="false"
            :trackBy="'user_id'" :label="'username'"
					  :class="{'form-danger': attendees.length == 0 && triedPost}"></MultiSelect>
		</div>
	  </div>

	  <div class="uk-margin">
		<label class="uk-form-label" for="form-horizontal-text">會議說明</label>
		  <div class="uk-form-controls">
			<textarea v-model="meeting.description" class="uk-textarea" rows="10" placeholder="會議說明..."
			:class="{'form-danger': !meeting.description && triedPost}"></textarea>
		  </div>
	  </div>
	  <div class="uk-margin uk-align-right">
		<button @click="postMeeting" class="uk-button uk-button-primary">送出</button>
	  </div>
	  </form>
	</div>
  </div>
</div>
</template>

<style scoped>
.multi-select {
  transition: border 0.2s ease-in-out;
  border: 1px solid transparent;
}
.form-danger {
  border: 1px solid #f0506e;
}
</style>

<script>
import Multiselect from "vue-multiselect";
import FlatPickr from "vue-flatpickr-component";

export default {
  data() {
    return {
      editMode: !!this.$route.params.id,
      meeting: {},
      groupedTas: {},
      triedPost: false,
      groupOptions: [],
      originalAttendees: [],
      attendees: [],
      attendeeOptions: [],
      flatPickrConfig: {
        enableTime: true
      }
    };
  },
  components: {
    Multiselect,
    FlatPickr
  },
  created() {
    this.fetchTAs();
    this.fetchMeeting();
  },
  methods: {
    fetchTAs: function() {
      axios.get("/api/tas/grouped").then(response => {
        this.groupedTas = response.data;
        this.groupOptions = Object.keys(this.groupedTas);
        this.groupOptions.forEach(group =>
          this.attendeeOptions.push({
            username: group,
            user_id: group,
            type: "group"
          })
        );
        for (let group in this.groupedTas) {
          this.attendeeOptions = this.attendeeOptions.concat(
            this.groupedTas[group]
          );
        }
        this.attendeeOptions = _.uniqBy(this.attendeeOptions, "user_id");
      });
    },
    fetchMeeting: function() {
      if (this.editMode) {
        axios
          .get(`/api/meeting/${this.$route.params.id}`)
          .then(response => (this.meeting = response.data));
        axios
          .get(`/api/attendee/meeting_id/${this.$route.params.id}/user_id`)
          .then(response => {
            this.attendees = response.data;
            this.originalAttendees = this.attendees;
          });
      }
    },

    attendeeSelected: function(selectedOption, id) {
      let selected = _.last(selectedOption);
      if (selected.type === "group") {
        this.attendees.pop();
        this.attendees = this.attendees.concat(
          this.groupedTas[selected.username]
        );
        this.attendees = _.uniqBy(this.attendees, "user_id");
      }
    },

    postMeeting: function() {
      this.triedPost = true;
      if (
        !!this.meeting.title &&
        !!this.meeting.description &&
        !!this.meeting.group &&
        !!this.meeting.scheduled_time &&
        !!this.attendees
      ) {
        if (this.editMode) {
          axios
            .put(`/api/meeting/${this.$route.params.id}`, this.meeting)
            .then(response => {
              this.postAttendees(response.data.id);
            });
        } else {
          axios.post("/api/meeting/", this.meeting).then(response => {
            this.postAttendees(response.data.id);
          });
        }
      }
    },
    postAttendees: function(meetingId) {
      let promises = [];
      let removedAttendees = _.without(
        this.originalAttendees,
        ...this.attendees
      );
      let newAttendees = _.without(this.attendees, ...this.originalAttendees);
      newAttendees.forEach(attendee => {
        promises.push(
          axios.post(`/api/attendee/meeting_id/${meetingId}/user_id`, {
            user_id: attendee.user_id
          })
        );
      });

      removedAttendees.forEach(attendee => {
        promises.push(
          axios.delete(
            `/api/attendee/meeting_id/${meetingId}/user_id/${attendee}`
          )
        );
      });

      axios.all(promises).then(() => {
        this.$router.push({
          name: "detail",
          params: { id: meetingId, view: "properties" }
        });
      });
    }
  }
};
</script>
