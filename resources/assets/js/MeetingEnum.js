const meetingStatus = Object.freeze({
  Init: 1,
  Start: 2,
  End: 3,
  Complete: 4,
  Archive: 5,
  Cancel: 6,
});

const meetingStatusText = Object.freeze([
  '', '未開始', '進行中', '未提交報帳',
  '等待報帳', '已封存', '已取消',
]);

const attendeeStatus = Object.freeze({
  Absent: 1,
  LateOrLeaveEarly: 2,
  OnTime: 3,
});

export default {
  meetingStatus,
  meetingStatusText,
  attendeeStatus,
};
