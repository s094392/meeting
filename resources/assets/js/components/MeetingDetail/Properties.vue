<template>
<div>
  <div class="uk-overflow-auto">
    <table class="uk-table uk-table-small uk-table-striped">
      <tr>
        <th>會議名稱:</th>
        <td>{{ meeting.title }}</td>
      </tr>
      <tr>
        <th>會議分類:</th>
        <td>{{ meeting.group }}</td>
      </tr>
      <tr>
        <th>預定開始時間:</th>
        <td>{{ meeting.scheduled_time }}</td>
      </tr>
      <tr>
        <th>開始時間:</th>
        <td>{{ meeting.start_time }}</td>
      </tr>
      <tr>
        <th>結束時間:</th>
        <td>{{ meeting.end_time }}</td>
      </tr>
      <tr>
        <th>發起人:</th>
        <td>{{ meeting.owner_name }}</td>
      </tr>
      <tr>
        <th>會議狀態:</th>
        <td>{{ this.$meetingStatusText[meeting.status] }}</td>
      </tr>
      <tr>
        <th>是否報帳:</th>
        <td v-if="meeting.request_money">是</td>
        <td v-else>否</td>
      </tr>
      <tr>
        <th>會議說明:</th>
        <td class="pre-wrap">{{ meeting.description }}</td>
      </tr>
    </table>
  </div>
  <hr class="uk-divider-icon">
</div>
</template>

<style lang="scss" scoped>
th {
  vertical-align: initial;
}
</style>

<script>
import { mapState } from 'vuex';

export default {
  computed: mapState(['user']),
  props: ['meeting'],
};
</script>
