<template>
<div>
  <div>
    <h3>準時成員</h3>
    <span v-for="attendee in attendees" :key="attendee.user_id" class="name-tag clickable" >{{ attendee.user_id }}</span>
    <h3>遲到成員</h3>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" >yahsieh</button>
    <h3>早退成員</h3>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wwchung</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color">
      <span uk-icon="plus"></span>
    </button>
    <div uk-dropdown="mode: click">
      成員: <Multiselect v-model="attendeeValue" :options="attendeeOptions" autofocus></MultiSelect>
      時間: <br/><FlatPickr v-model="time" :config="config"></FlatPickr>
      <br/>
      <br/>
      <br/>
      <a href="#" class="uk-button uk-button-primary uk-button-small">確定</a>
    </div>


    <h3>請假成員</h3>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wwchung</button>
    <h3>翹咪成員</h3>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wwchung</button>
  </div>

</div>
</template>



<script>
import Multiselect from "vue-multiselect";
import FlatPickr from "vue-flatpickr-component";

export default {
  created() {
    this.fetchAttendees();
  },
  data() {
    return {
      config: {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        static: true
      },
      show: false,
      time: "",
      attendeeValue: null,
      attendeeOptions: ["Linux", "mllee", "calee"],
      attendees: [],
      id: this.$route.params.id
    };
  },
  components: {
    Multiselect,
    FlatPickr
  },
  methods: {
    fetchAttendees: function() {
      var self = this;
      axios
        .get("/api/attendee/meeting_id/" + self.id + "/user_id")
        .then(response => {
          this.attendees = response.data;
        });
    }
  }
};
</script>
