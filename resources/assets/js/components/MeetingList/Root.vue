<template>
<div uk-grid>

	<div class="uk-width-3-4@l">
		<h2 class="uk-display-inline">所有會議</h2>
		<button class="uk-button uk-button-primary uk-align-right uk-hidden@l" uk-toggle="target: #meeting-filter">篩選器</button>
    <div class="uk-card uk-card-default uk-overflow-auto uk-width-1-1 uk-margin-top">
      <table class="uk-table uk-table-hover uk-table-divider meetings-table">
        <thead>
          <tr>
            <th>#</th>
            <th>會議分類</th>
            <th>會議名稱</th>
            <th>開始時間</th>
            <th>結束時間</th>
            <th>發起人</th>
            <th>會議狀態</th>
          </tr>
        </thead>
        <tbody @click="toMeeting(meeting.id)" v-for="meeting in meetings" :key="meeting.id" :meeting="meeting">
          <tr class="meeting-tr">
            <td>{{ meeting.id }}</td>
            <td >{{ meeting.group }}</td>
            <td >{{ meeting.title }}</td>
            <td >{{ meeting.start_time }}</td>
            <td>{{ meeting.end_time }}</td>
            <td>{{ meeting.owner }}</td>
            <td>{{ $meetingStatusText[meeting.status] }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <ul class="uk-pagination uk-flex-center" uk-margin>
      <li><a href="#"><span uk-pagination-previous></span></a></li>
      <li><a href="#">1</a></li>
      <li class="uk-disabled"><span>...</span></li>
      <li><a href="#">5</a></li>
      <li><a href="#">6</a></li>
      <li class="uk-active"><span>7</span></li>
      <li><a href="#">8</a></li>
      <li><a href="#"><span uk-pagination-next></span></a></li>
    </ul>
  </div>

  <div class="uk-width-1-4@l uk-visible@l">
    <h4>篩選器</h4>
    <div class="uk-card uk-card-body uk-card-small uk-card-default" uk-sticky="offset: 40;">
      <MeetingFilter :groupOptions="groupOptions" :ownerOptions="ownerOptions" @search="search"/>
    </div>
  </div>

  <div id="meeting-filter" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
      <button class="uk-modal-close-default" type="button" uk-close></button>
      <h4>篩選器</h4>
      <MeetingFilter :groupOptions="groupOptions" :ownerOptions="ownerOptions" @search="search"/>
    </div>
  </div>
</div>
</template>

<style lang="scss" scoped>
.meeting-tr {
  cursor: pointer;
}
</style>


<script>
import MeetingFilter from "./MeetingFilter";
export default {
  created() {
    this.fetchMeetings();
    this.fetchTas();
  },
  components: {
    MeetingFilter
  },
  data() {
    return {
      meetings: [],
      groupOptions: [],
      ownerOptions: []
    };
  },
  methods: {
    fetchMeetings: function() {
      axios.get("/api/meeting").then(response => {
        this.meetings = response.data;
      });
    },
    fetchTas: function() {
      axios
        .get("api/tas/list")
        .then(response => (this.ownerOptions = response.data));
      axios
        .get("api/tas/grouped")
        .then(response => (this.groupOptions = Object.keys(response.data)));
    },
    toMeeting: function(meetingId) {
      this.$router.push({
        name: "detail",
        params: { id: meetingId, view: "properties" }
      });
    },
    search: function(title, group, startDate, endDate, owner, status) {
      axios
        .get("api/meeting", {
          params: {
            title: title,
            group: group,
            startDate: startDate,
            endDate: endDate,
            owner: owner,
            "status[]": status
          }
        })
        .then(response => (this.meetings = response.data));
    }
  }
};
</script>
