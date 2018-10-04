<template>
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
    <td class="uk-visible@m nowrap">{{ removeSecond(meeting.start_time) }}</td>
    <td class="uk-visible@m nowrap">{{ removeSecond(meeting.end_time) }}</td>
    <td class="uk-visible@m">{{ meeting.owner_name }}</td>
    <td class="nowrap">{{ $meetingStatusText[meeting.status] }}</td>
    </tr>
  </tbody>
</table>
</template>

<style lang="scss" scoped>
.nowrap {
  white-space: nowrap;
}
</style>


<script>
export default {
  props: ['meetings'],
  methods: {
    toMeeting(meetingId) {
      this.$router.push({
        name: 'detail',
        params: { id: meetingId, view: 'properties' },
      });
    },
    removeSecond(s) {
      if (!s) return s;
      return s.slice(0, -3);
    },
  },
};
</script>
