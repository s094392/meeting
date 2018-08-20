<template>
<div>
  <table class="uk-table uk-table-small ">
    <tr>
      <th>會議名稱:</th>
      <td>NET Meeting 暨 新生報告</td>
    </tr>
    <tr>
      <th>會議分類:</th>
      <td>Network</td>
    </tr>
    <tr>
      <th>預定開始時間:</th>
      <td>Not set</td>
    </tr>
    <tr>
      <th>開始時間:</th>
      <td>2018-08-16 19:36:03</td>
    </tr>
    <tr>
      <th>結束時間:</th>
      <td>Not set</td>
    </tr>
    <tr>
      <th>發起人:</th>
      <td>calee (李家安)</td>
    </tr>
    <tr>
      <th>會議狀態:</th>
      <td>會議結束，但會議記錄未確認</td>
    </tr>
    <tr>
      <th>會議時數:</th>
      <td>270 分鐘</td>
    </tr>
    <tr>
      <th>會議說明:</th>
      <td>我要吃雞雞叫 雞雞叫的菜單呢</td>
    </tr>
  </table>
  <hr class="uk-divider-icon">
  <MeetingControl />
</div>
</template>

<script>
import MeetingControl from "./MeetingControl";
export default {
  components: {
    MeetingControl
  }
};
</script>
