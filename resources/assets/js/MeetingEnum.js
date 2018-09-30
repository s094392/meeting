const meetingStatus = Object.freeze({
  Init: 1,
  Start: 2,
  End: 3,
  RecordComplete: 4,
  Archive: 5,
});

const meetingStatusText = Object.freeze([
  '',
  '新會議',
  '進行中',
  '等待發起人確認',
  '會議記錄完成',
  '已報帳封存',
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
