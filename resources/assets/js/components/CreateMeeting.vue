<template>
<div uk-grid>
  <div class="uk-width-3-4@m">
    <h2>新增會議</h2>
    <div class="uk-card uk-card-default uk-card-body uk-card-small">
      <form v-on:submit.prevent class="uk-form-horizontal uk-margin-large">

      <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-text">會議名稱</label>
        <div class="uk-form-controls">
          <input v-model="title" class="uk-input"
          :class="{'form-danger': !title && triedPost}" type="text" placeholder="輸入會議名稱...">
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-text">會議組別</label>
        <div class="uk-form-controls">
          <multiselect class="multi-select" v-model="team" placeholder="選擇會議組別..." 
          :class="{'form-danger': !team && triedPost}" :options="teamOptions" ></multiselect>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-text">開會時間</label>
        <div class="uk-form-controls">
          <FlatPickr v-model="scheduled_time" :config="flatPickrConfig" class="flatpickr-input"
          :class="{'form-danger': !scheduled_time && triedPost}" placeholder="選擇開會時間..."></FlatPickr>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-text">參與人員</label>
        <div class="uk-form-controls">
          <Multiselect class="multi-select" v-model="attendees" @input="attendeeSelected" placeholder="選擇參與人員..."
                      :options="attendeeOptions" :hideSelected="true" :multiple="true" :closeOnSelect="false"
                      :class="{'form-danger': attendees.length == 0 && triedPost}"></MultiSelect>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-text">會議說明</label>
          <div class="uk-form-controls">
            <textarea v-model="description" class="uk-textarea" rows="10" placeholder="會議說明..."
            :class="{'form-danger': !description && triedPost}"></textarea>
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
      triedPost: false,
      title: "",
      description: "",
      team: "",
      teamOptions: ["www", "linux"],
      meeting: {},
      scheduled_time: "",
      attendees: [],
      attendeeOptions: [
        "mllee",
        "calee",
        "chenshh",
        "yanglin",
        "calee",
        "hcchuang",
        "hcdai",
        "yysung",
        "fuyu0425",
        "yca",
        "hchsu042",
        "wangtr",
        "yaowen",
        "linsc04",
        "youwei11",
        "yenck",
        "syujy",
        "zswu",
        "yahsieh",
        "tsengcy",
        "wengyc",
        "kuohh",
        "Linux"
      ],
      flatPickrConfig: {
        enableTime: true
      }
    };
  },
  components: {
    Multiselect,
    FlatPickr
  },
  methods: {
    attendeeSelected: function(selectedOption, id) {
      if (_.last(selectedOption) == "Linux") {
        _.remove(this.attendeeOptions, option => option == "Linux");
        this.attendees.pop();
        this.attendees.push("tsengcy", "wengyc", "mllee", "apple");
        this.attendees = _.uniq(this.attendees);
      }
    },
    postMeeting: function() {
      this.triedPost = true;
      if (
        !!this.title &&
        !!this.description &&
        !!this.team &&
        !!this.scheduled_time &&
        !!this.attendees &&
        !!this.description
      ) {
        axios
          .post("/api/meeting", {
            title: this.title,
            description: this.description,
            team: this.team,
            scheduled_time: this.scheduled_time,
            record: this.description,
            status: "Initialized"
          })
          .then(response => {
            this.postAttendees(response.data.id);
          });
      }
    },
    postAttendees: function(meetingId) {
      var promises = [];
      this.attendees.forEach(attendee => {
        promises.push(
          axios.post(`/api/attendee/meeting_id/${meetingId}/user_id`, {
            user_id: attendee,
            status: "Initialized"
          })
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
