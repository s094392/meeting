<template>
  <div>
    <h4>已結束的會議</h4>
    <span v-if="meetings === null">載入中...</span>
    <span v-else-if="meetings.length === 0">無資料</span>
    <template v-else>
      <InactiveMeetingCard v-for="meeting in meetings" :key="meeting.id" :meeting="meeting"/>
    </template>
    <div class="uk-text-right uk-margin-left">
      <router-link :to="{ name: 'list' }">顯示更多</router-link>
    </div>
  </div>
</template>

<script>
import InactiveMeetingCard from './InactiveMeetingCard';

export default {
  components: {
    InactiveMeetingCard,
  },
  created() {
    this.fetchMeetings();
  },
  data() {
    return {
      meetings: null,
    };
  },
  methods: {
    fetchMeetings() {
      axios
        .get('/api/meetings', {
          params: {
            per_page: 5,
            status: [
              this.$meetingStatus.End,
              this.$meetingStatus.RecordComplete,
              this.$meetingStatus.Archive,
              this.$meetingStatus.Cancel,
            ],
          },
        })
        .then((response) => {
          this.meetings = response.data.data;
        });
    },
  },
};
</script>
