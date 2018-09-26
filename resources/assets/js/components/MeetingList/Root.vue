<template>
<div uk-grid>
  <div class="uk-width-3-4@l">
    <h2 class="uk-display-inline">所有會議</h2>
    <button class="uk-button uk-button-primary uk-align-right uk-hidden@l"
            uk-toggle="target: #meeting-filter">篩選器</button>
    <div class="uk-card uk-card-default uk-overflow-auto uk-width-1-1 uk-margin-top">
      <table class="uk-table uk-table-hover uk-table-divider meetings-table">
        <thead>
          <tr>
            <th>#</th>
            <th>會議分類</th>
            <th>會議名稱</th>
            <th class="uk-visible@m">開始時間</th>
            <th class="uk-visible@m">結束時間</th>
            <th class="uk-visible@m">發起人</th>
            <th>會議狀態</th>
          </tr>
        </thead>
        <tbody @click="toMeeting(meeting.id)" v-for="meeting in meetings"
               :key="meeting.id" :meeting="meeting">
          <tr class="cursor-pointer">
            <td>{{ meeting.id }}</td>
            <td >{{ meeting.group }}</td>
            <td >{{ meeting.title }}</td>
            <td class="uk-visible@m">{{ meeting.start_time }}</td>
            <td class="uk-visible@m">{{ meeting.end_time }}</td>
            <td class="uk-visible@m">{{ meeting.owner_name }}</td>
            <td>{{ $meetingStatusText[meeting.status] }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <ul class="uk-pagination uk-flex-center" uk-margin>
      <li v-if="page !== 1">
        <router-link :to="{ name: 'list', params: { page: 1 }, query }">
          <span class="uk-icon">
            <svg class="svg-fix" width="7" height="12"
              viewBox="0 0 7 12" xmlns="http://www.w3.org/2000/svg">
              <polyline fill="none" stroke="#000" stroke-width="1" points="6 1 1 6 6 11">
              </polyline>
            </svg><svg class="svg-fix" width="7" height="12" viewBox="0 0 7 12" xmlns="http://www.w3.org/2000/svg">
              <polyline fill="none" stroke="#000" stroke-width="1" points="6 1 1 6 6 11">
            </polyline>
            </svg>
          </span>
        </router-link>
      </li>
      <template v-for="idx in pageRange()">
        <li :key="idx" >
          <router-link :to="{ name: 'list', params: { page: idx }, query}">{{idx}}</router-link>
        </li>
      </template>
      <li v-if="page !== lastPage">
        <router-link :to="{ name: 'list', params: { page: lastPage }, query }">
          <span class="uk-icon">
            <svg class="svg-fix" width="7" height="12"
              viewBox="0 0 7 12" xmlns="http://www.w3.org/2000/svg">
              <polyline fill="none" stroke="#000" stroke-width="1" points="1 1 6 6 1 11">
              </polyline>
            </svg><svg class="svg-fix" width="7" height="12" viewBox="0 0 7 12" xmlns="http://www.w3.org/2000/svg">
              <polyline fill="none" stroke="#000" stroke-width="1" points="1 1 6 6 1 11">
            </polyline>
            </svg>
          </span>
        </router-link>
      </li>
    </ul>
  </div>

  <div class="uk-width-1-4@l uk-visible@l">
    <h4>篩選器</h4>
    <div class="uk-card uk-card-body uk-card-small uk-card-default" uk-sticky="offset: 40;">
      <MeetingFilter :query="query" :groupOptions="groupOptions"
                     :ownerOptions="ownerOptions"/>
    </div>
  </div>

  <div id="meeting-filter" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
      <button class="uk-modal-close-default" type="button" uk-close></button>
      <h4>篩選器</h4>
      <MeetingFilter :query="query" :groupOptions="groupOptions"
                     :ownerOptions="ownerOptions"/>
    </div>
  </div>
</div>
</template>

<style lang="scss" scoped>
.svg-fix {
  padding-bottom: 2px;
}
</style>


<script>
import MeetingFilter from './MeetingFilter';

export default {
  created() {
    this.fetchMeetings();
    this.fetchTas();
  },
  components: {
    MeetingFilter,
  },
  data() {
    return {
      meetings: [],
      groupOptions: [],
      ownerOptions: [],
      lastPage: undefined,
    };
  },
  computed: {
    query() {
      return this.$route.query;
    },
    page() {
      return parseInt(this.$route.params.page, 10);
    },
  },
  watch: {
    query() {
      this.fetchMeetings();
    },
  },
  methods: {
    pageRange() {
      let start = this.page - 3;
      let end = this.page + 3;
      if (start <= 0) {
        end += Math.abs(start - 1);
        start = 1;
      }
      if (end > this.lastPage) {
        start -= Math.abs(end - this.lastPage);
        end = this.lastPage;
      }
      return _.range(Math.max(1, start), end + 1);
    },
    fetchMeetings() {
      axios.get('/api/meeting', {
        params: {
          page: this.page,
          ...this.query,
        },
      }).then((response) => {
        this.lastPage = parseInt(response.data.last_page, 10);
        this.meetings = response.data.data;
      });
    },
    fetchTas() {
      axios
        .get('api/tas/list')
        .then((response) => { this.ownerOptions = response.data; });
      axios
        .get('api/tas/grouped')
        .then((response) => { this.groupOptions = Object.keys(response.data); });
    },
    toMeeting(meetingId) {
      this.$router.push({
        name: 'detail',
        params: { id: meetingId, view: 'properties' },
      });
    },
  },
};
</script>
