<template>
<div uk-grid>
  <div class="uk-width-3-4@l">
    <span class="page-title">個人報表</span>
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
            <button @click="$router.push( {name: 'profile', params: {year, month}})"
                    class="uk-button uk-button-primary">
              查詢
            </button>
          </div>
          <ul class="uk-list uk-list-bullet" v-if="stats">
            <li><span class="uk-text-bold meeting-hours">開了{{ stats.totalTime }}小時的會議</span></li>
            <li>應該參加：{{ stats.shouldAttend }}次</li>
            <li>請假：{{ stats.absentWithReason }}次</li>
            <li>翹咪：{{ stats.absentWithoutReason }}次</li>
            <li>遲到：{{ stats.late }}次</li>
            <li>早退：{{ stats.leaveEarly }}次</li>
          </ul>
        </div>
        <Doughnut class="uk-width-1-2@s" :timePerGroup="stats.timePerGroup" v-if="stats">
        </Doughnut>
      </div>
      <div class="uk-margin-top">
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
import MeetingEnum from '../../MeetingEnum';
import store from '../../store';

const fetchAndCalc = (to, from, next, self) => {
  const startDate = moment().set({
    year: to.params.year,
    month: to.params.month - 1,
    date: 1,
  });
  const meetings = [];
  const stats = {
    shouldAttend: 0,
    absentWithReason: 0,
    absentWithoutReason: 0,
    late: 0,
    totalTime: 0,
    leaveEarly: 0,
    timePerGroup: {},
  };

  axios.get(`/api/users/${store.state.user.user_id}`, {
    params: {
      startDate: startDate.format('YYYY-MM-DD'),
      endDate: startDate.add(1, 'month').subtract(1, 'day').format('YYYY-MM-DD'),
      status: [
        MeetingEnum.meetingStatus.End,
        MeetingEnum.meetingStatus.RecordComplete,
        MeetingEnum.meetingStatus.Archive,
      ],
      attendees: true,
    },
  }).then((response) => {
    response.data.meetings.forEach((meeting) => {
      const me = meeting.attendees.find(
        attendee => attendee.user_id === store.state.user.user_id,
      );
      meetings.push(meeting);

      let endTime = moment(meeting.end_time);
      const startTime = moment(meeting.start_time);

      stats.shouldAttend += 1;
      if (me.status === MeetingEnum.attendeeStatus.Absent) {
        if (me.absent_reason) stats.absentWithReason += 1;
        else stats.absentWithoutReason += 1;
        endTime = startTime;
      }

      if (me.status === MeetingEnum.attendeeStatus.LateOrLeaveEarly && me.arrive_time) {
        stats.late += 1;
        const arriveTime = moment(me.arrive_time, 'HH:mm:ss');
        startTime.set({
          hour: arriveTime.get('hour'),
          minute: arriveTime.get('minute'),
          second: arriveTime.get('second'),
        });
      }
      if (me.status === MeetingEnum.attendeeStatus.LateOrLeaveEarly && me.leave_time) {
        stats.leaveEarly += 1;
        const leaveTime = moment(me.leave_time, 'HH:mm:ss');
        startTime.set({
          hour: leaveTime.get('hour'),
          minute: leaveTime.get('minute'),
          second: leaveTime.get('second'),
        });
      }

      const meetingTime = (endTime - startTime) / 3600000;
      stats.totalTime += meetingTime;
      if (meeting.group in stats.timePerGroup) {
        stats.timePerGroup[meeting.group] += meetingTime;
      } else {
        stats.timePerGroup[meeting.group] = meetingTime;
      }
    });
    Object.keys(stats.timePerGroup).forEach((el) => {
      stats.timePerGroup[el] = Math.round(stats.timePerGroup[el] * 100) / 100;
    });
    stats.totalTime = Math.round(stats.totalTime * 100) / 100;
    if (self) {
      self.setData(meetings, stats);
      next();
    } else {
      next(vm => vm.setData(meetings, stats));
    }
  });
};


export default {
  computed: mapState(['user']),
  components: {
    Doughnut,
    MeetingTable,
  },
  data() {
    return {
      meetings: [],
      yearList: [],
      year: 0,
      month: 0,
      stats: null,
    };
  },
  beforeRouteEnter(to, from, next) {
    fetchAndCalc(to, from, next, null);
  },
  beforeRouteUpdate(to, from, next) {
    fetchAndCalc(to, from, next, this);
  },
  created() {
    this.year = this.$route.params.year;
    this.month = this.$route.params.month;
    this.yearList = _.range(moment().get('year') - 10, moment().get('year') + 1);
  },
  methods: {
    setData(meetings, stats) {
      this.stats = Object.assign({}, stats);
      this.meetings = Object.assign({}, meetings);
    },

  },
};
</script>
