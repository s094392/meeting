<template>
  <div>
    <h4>已結束的會議</h4>
    <InactiveMeetingCard v-for="meeting in meetings" :key="meeting.id" :meeting="meeting"/>
    <div class="uk-text-right uk-margin-left">
      <router-link :to="{name:'list'}">顯示更多</router-link>
    </div>
  </div>
</template>

<script>
import InactiveMeetingCard from "./InactiveMeetingCard";

export default {
  components: {
    InactiveMeetingCard
  },
  created() {
    this.fetchMeetings();
  },
  data() {
    return {
      meetings: []
    };
  },
  methods: {
    fetchMeetings: function() {
      axios
        .get("/api/meeting", {
          params: {
            status: [
              this.$meetingStatus.End,
              this.$meetingStatus.RecordComplete,
              this.$meetingStatus.Archive
            ]
          }
        })
        .then(response => {
          this.meetings = response.data;
        });
    }
  }
};
</script>
