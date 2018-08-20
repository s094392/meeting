<template>
<div uk-grid>

	<div class="uk-width-3-4@m">
		<h2 class="uk-display-inline">所有會議</h2>
		<button class="uk-button uk-button-primary uk-align-right uk-hidden@m" uk-toggle="target: #meeting-filter">篩選器</button>
    <div class="uk-card uk-card-default uk-overflow-auto uk-width-1-1 uk-margin-top">
      <table class="uk-table uk-table-hover uk-table-divider meetings-table">
        <thead>
          <tr>
            <th>#</th>
            <th>會議分類</th>
            <th>會議名稱</th>
            <th>開始時間</th>
            <th>結束時間</th>
            <th>發起人</th>
            <th>會議狀態</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>100</td>
            <td >NET</td>
            <td >Meeting 暨 新生報告</td>
            <td >2018-08-16 19:36</td>
            <td>2018-08-17 13:22</td>
            <td >0000000000</td>
            <td >會議結束</td>
          </tr>
          <tr>
            <td>100</td>
            <td>Net</td>
            <td>Meeting 暨 新生報告</td>
            <td>2018-08-16 19:36</td>
            <td>2018-08-17 13:22</td>
            <td>0000000000</td>
            <td>會議結束</td>
          </tr>
          <tr>
            <td>100</td>
            <td>NET</td>
            <td>Meeting 暨 新生報告</td>

            <td>2018-08-16 19:36</td>
            <td>2018-08-17 13:22</td>
            <td>0000000000</td>
            <td>會議結束</td>
          </tr>
        </tbody>
      </table>
    </div>
    <ul class="uk-pagination uk-flex-center" uk-margin>
      <li><a href="#"><span uk-pagination-previous></span></a></li>
      <li><a href="#">1</a></li>
      <li class="uk-disabled"><span>...</span></li>
      <li><a href="#">5</a></li>
      <li><a href="#">6</a></li>
      <li class="uk-active"><span>7</span></li>
      <li><a href="#">8</a></li>
      <li><a href="#"><span uk-pagination-next></span></a></li>
    </ul>
  </div>

  <div class="uk-width-1-4@m uk-visible@m">
    <h4>篩選器</h4>
    <div class="uk-card uk-card-body uk-card-small uk-card-default" uk-sticky="offset: 40;">
      <MeetingFilter/>
    </div>
  </div>

  <div id="meeting-filter" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
      <button class="uk-modal-close-default" type="button" uk-close></button>
      <h4>篩選器</h4>
      <MeetingFilter/>
    </div>
  </div>
</div>
</template>

<script>
import MeetingFilter from "./MeetingFilter";
export default {
  components: {
    MeetingFilter
  }
};
</script>
