<template>
  <div>
    <div>
      <h2 class="uk-display-inline">近期會議</h2>
      <router-link :to="{name:'new'}" class="uk-button uk-button-primary uk-align-right">新增會議</router-link>
    </div>
    <ActiveMeetingCard v-for="meeting in meetings" :key="meeting.id" :meeting="meeting"/>
  </div>
</template>

<script>
import ActiveMeetingCard from "./ActiveMeetingCard";

export default {
  created() {
    this.fetchMeetings();
  },
  data(){
    return {
      meetings: []
    };
  },
  components: {
    ActiveMeetingCard
  },
  methods: {
    fetchMeetings: function() {
      axios
        .get("/api/meeting")
        .then(response => {
          this.meetings = response.data;
        });
    },
  }
};
</script>
