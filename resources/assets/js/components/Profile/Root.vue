<template>
<div uk-grid>
  <div class="uk-width-3-4@l">
    <h2>個人報表</h2>
    <div class="uk-card uk-card-default uk-card-body uk-card-small">
      <div uk-grid >
         <div class="uk-width-1-2@s">
          <div class="uk-text-large uk-text-lead">
            <select class="uk-select" v-model="year">
              <option v-for="year in yearList" :key="year" :value="year">{{year}}</option>
            </select>
            <select class="uk-select" v-model="month">
              <option v-for="month in 12" :key="month" :value="month">{{month}}</option>
            </select>
            <button @click="fetchMeetings" class="uk-button uk-button-primary" :disabled="loading">
              查詢
            </button>
          </div>
          <ul class="uk-list uk-list-bullet" v-if="!loading">
            <li><span class="uk-text-bold meeting-hours">開了{{ totalTime }}小時的會議</span></li>
            <li>應該參加：{{ shouldAttend }}次</li>
            <li>舉辦：{{ own }}次</li>
            <li>請假：{{ absentWithReason }}次</li>
            <li>翹咪：{{ absentWithoutReason }}次</li>
            <li>遲到：{{ late }}次</li>
            <li>早退：{{ leaveEarly }}次</li>
          </ul>

        </div>
        <Doughnut class="uk-width-1-2@s" :timePerGroup="timePerGroup"
                  v-if="!loading">
        </Doughnut>
      </div>
      <div class="uk-margin-top" v-if="!loading">
        <MeetingTable :meetings="meetings"></MeetingTable>
      </div>
    </div>
  </div>
</div>
</template>

<style lang="scss" scoped>
.meeting-hours {
  font-size: 1.2rem;
}
.uk-select {
  width: inherit;
}
</style>


<script>
import { mapState } from 'vuex';
import moment from 'moment';
import Doughnut from './Doughnut';
import MeetingTable from '../Shared/MeetingTable';

export default {
  computed: mapState(['user']),
  components: {
    Doughnut,
    MeetingTable,
  },
  data() {
    return {
      meetings: [],
      timePerGroup: {},
      shouldAttend: 0,
      own: 0,
      absentWithReason: 0,
      absentWithoutReason: 0,
      late: 0,
      leaveEarly: 0,
      loading: false,
      totalTime: 0,
      year: 0,
      month: 0,
      yearList: [],
    };
  },
  created() {
    const now = moment();
    this.year = now.year();
    this.yearList = _.range(this.year - 10, this.year + 1);
    this.month = now.month() + 1;
    this.fetchMeetings();
  },
  methods: {
    toMeeting(meetingId) {
      this.$router.push({
        name: 'detail',
        params: { id: meetingId, view: 'properties' },
      });
    },
    clearVariables() {
      this.meetings = [];
      this.timePerGroup = {};
      this.shouldAttend = 0;
      this.own = 0;
      this.absentWithReason = 0;
      this.absentWithoutReason = 0;
      this.late = 0;
      this.leaveEarly = 0;
      this.totalTime = 0;
    },
    fetchMeetings() {
      if (this.loading) return;
      this.loading = true;
      this.clearVariables();
      const startDate = moment().set({
        year: this.year,
        month: this.month - 1,
        date: 1,
      });
      axios
        .get('/api/meeting', {
          params: {
            startDate: startDate.format('YYYY-MM-DD'),
            endDate: startDate.add(1, 'month').subtract(1, 'day').format('YYYY-MM-DD'),
            status: [this.$meetingStatus.End, this.$meetingStatus.RecordComplete,
              this.$meetingStatus.Archive],
          },
        })
        .then((response) => {
          const promises = [];
          response.data.forEach((meeting) => {
            promises.push(axios
              .get(
                `/api/attendee/meeting_id/${meeting.id}/user_id/${this.user.user_id}`,
              )
              .then((response2) => {
                const me = response2.data;
                if (me || meeting.owner === this.user.user_id) {
                  this.meetings.push(meeting);

                  let endTime = moment(meeting.end_time);
                  const startTime = moment(meeting.start_time);

                  if (me) {
                    this.shouldAttend += 1;
                    if (me.status === this.$attendeeStatus.Absent) {
                      if (me.absent_reason) this.absentWithReason += 1;
                      else this.absentWithoutReason += 1;
                      endTime = startTime;
                    }
                    if (me.status === this.$attendeeStatus.LateOrLeaveEarly
                        && me.arrive_time) {
                      this.late += 1;
                      const arriveTime = moment(me.arrive_time, 'HH:mm:ss');
                      startTime.set({
                        hour: arriveTime.get('hour'),
                        minute: arriveTime.get('minute'),
                        second: arriveTime.get('second'),
                      });
                    }
                    if (me.status === this.$attendeeStatus.LateOrLeaveEarly
                        && me.leave_time) {
                      this.leaveEarly += 1;
                      const leaveTime = moment(me.leave_time, 'HH:mm:ss');
                      startTime.set({
                        hour: leaveTime.get('hour'),
                        minute: leaveTime.get('minute'),
                        second: leaveTime.get('second'),
                      });
                    }

                    const meetingTime = (endTime - startTime) / 3600000;
                    this.totalTime += meetingTime;
                    if (meeting.group in this.timePerGroup) {
                      this.timePerGroup[meeting.group] += meetingTime;
                    } else {
                      this.timePerGroup[meeting.group] = meetingTime;
                    }
                  }
                  if (meeting.owner === this.user.user_id) this.own += 1;
                }
              }));
          });
          axios.all(promises).then(() => {
            Object.keys(this.timePerGroup).forEach((el) => {
              this.timePerGroup[el] = Math.round(this.timePerGroup[el] * 100) / 100;
            });
            this.totalTime = Math.round(this.totalTime * 100) / 100;
            this.loading = false;
          });
        });
    },
  },
};
</script>
