<template>
<div uk-grid>
  <div class="uk-width-3-4@l">
    <h2>個人報表</h2>
    <div v-if="!loading"  class="uk-card uk-card-default uk-card-body uk-card-small">
      <div uk-grid >
         <div class="uk-width-1-2@s">
          <div class="uk-text-large uk-text-lead">過去一個月你總共</div>
          <ul class="uk-list uk-list-bullet">
            <li><span class="uk-text-bold meeting-hours">開了{{ totalTime }}小時的會議</span></li>
            <li>應該參加：{{ shouldAttend }}次</li>
            <li>舉辦：{{ own }}次</li>
            <li>請假：{{ absentWithReason }}次</li>
            <li>翹咪：{{ absentWithoutReason }}次</li>
            <li>遲到：{{ late }}次</li>
            <li>早退：{{ leaveEarly }}次</li>
          </ul>

        </div>
        <Doughnut class="uk-width-1-2@s" :labels="Object.keys(timePerGroup)"
                  :data="Object.values(timePerGroup)">
        </Doughnut>
      </div>
      <div class="uk-margin-top">
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
    </div>
  </div>
</div>
</template>

<style lang="scss" scoped>
.meeting-hours {
  font-size: 1.2rem;
}
</style>


<script>
import { mapState } from 'vuex';
import moment from 'moment';
import Doughnut from './Doughnut';


export default {
  computed: mapState(['user']),
  components: { Doughnut },
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
      loading: true,
      totalTime: 0,
    };
  },
  created() {
    this.fetchMeetings();
  },
  methods: {
    toMeeting(meetingId) {
      this.$router.push({
        name: 'detail',
        params: { id: meetingId, view: 'properties' },
      });
    },
    fetchMeetings() {
      axios
        .get('/api/meeting', {
          params: {
            startDate: moment().subtract(1, 'month').format('YYYY-MM-DD'),
            endDate: moment().format('YYYY-MM-DD'),
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
