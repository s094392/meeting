<template>
<div uk-grid>
  <div class="uk-width-3-4@l">
    <span class="page-title">個人報表</span>
    <div class="uk-card uk-card-default uk-card-body uk-card-small">
      <div uk-grid >
         <div class="uk-width-1-2@s">
          <div class="uk-text-large uk-text-lead">
            <Multiselect class="uk-margin-small-bottom" v-model="query.user"
                         :options="userOption" :label="'username'" :trackBy="'user_id'">
                         <span slot="noResult">查無資料</span>
            </Multiselect>
            <select class="uk-select" v-model="query.year">
              <option v-for="year in yearList" :key="year" :value="year">{{year}}</option>
            </select>
            <select class="uk-select" v-model="query.month">
              <option v-for="month in 12" :key="month" :value="month">{{month}}</option>
            </select>
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
import range from 'lodash/range';
import Multiselect from '../Shared/MultiSelect';
import MeetingTable from '../Shared/MeetingTable';
import MeetingEnum from '../../MeetingEnum';

const fetchAndCalc = (to, from, next, self) => {
  const { year, month } = to.params;
  const userId = parseInt(to.params.userId, 10);
  const startDate = moment().set({
    year,
    month: month - 1,
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

  axios.get(`/api/users/${userId}`, {
    params: {
      startDate: startDate.format('YYYY-MM-DD'),
      endDate: startDate.add(1, 'month').subtract(1, 'day').format('YYYY-MM-DD'),
      status: [
        MeetingEnum.meetingStatus.Complete,
        MeetingEnum.meetingStatus.Archive,
      ],
      attendees: true,
    },
  }).then((response) => {
    response.data.meetings.forEach((meeting) => {
      const me = meeting.attendees.find(
        attendee => attendee.user_id === userId,
      );
      meetings.push(meeting);

      let endTime = moment(meeting.end_time);
      let startTime = moment(meeting.start_time);

      stats.shouldAttend += 1;
      if (me.status === MeetingEnum.attendeeStatus.Absent) {
        if (me.absent_reason) stats.absentWithReason += 1;
        else stats.absentWithoutReason += 1;
        endTime = startTime;
      }

      if (me.status === MeetingEnum.attendeeStatus.LateOrLeaveEarly && me.arrive_time) {
        stats.late += 1;
        startTime = moment(me.arrive_time);
      }
      if (me.status === MeetingEnum.attendeeStatus.LateOrLeaveEarly && me.leave_time) {
        stats.leaveEarly += 1;
        endTime = moment(me.leave_time);
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
      self.setData(year, month, meetings, stats);
      next();
    } else {
      next(vm => vm.setData(year, month, meetings, stats));
    }
  });
};


export default {
  computed: mapState(['user']),
  components: {
    Doughnut: () => import('./Doughnut' /* webpackChunkName: "js/doughnut" */),
    MeetingTable,
    Multiselect,
  },
  data() {
    return {
      meetings: [],
      yearList: [],
      userOption: [],
      firstFindEvent: false,
      query: {
        user: {
          user_id: this.$route.params.userId,
        },
        year: this.$route.params.year,
        month: this.$route.params.month,
      },
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
    this.yearList = range(moment().get('year') - 10, moment().get('year') + 1);
    this.fetchUsers();
  },
  watch: {
    query: {
      handler() {
        if (this.firstFindEvent === false) {
          this.$router.push({
            name: 'profile',
            params: {
              year: this.query.year,
              month: this.query.month,
              userId: this.query.user.user_id,
            },
          });
        }
      },
      deep: true,
    },
  },
  methods: {
    setData(year, month, meetings, stats) {
      this.stats = Object.assign({}, stats);
      this.meetings = Object.assign({}, meetings);
    },
    fetchUsers() {
      axios.get('/api/tas').then((response) => {
        this.userOption = response.data['cs-ta'];
        this.firstFindEvent = true;
        this.query.user = this.userOption.find(
          user => parseInt(user.user_id, 10) === parseInt(this.$route.params.userId, 10),
        );
        this.firstFindEvent = false;
      });
    },
  },
};
</script>
