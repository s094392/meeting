<template>
<div class="uk-modal-dialog uk-modal-body">
  <h2 class="uk-modal-title" v-if="type === 'late'">遲到成員</h2>
  <h2 class="uk-modal-title" v-else>早退成員</h2>
  <form class="uk-form-stacked">

    <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-text">ID</label>
        <div class="uk-form-controls">
            <Multiselect v-model="attendeeValue" :options="attendeesOption"
                         :trackBy="'user_id'" :label="'username'" :disabled="mode === 'edit'">
                <span slot="noResult">查無資料</span>
            </MultiSelect>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-text" v-if="type === 'late'">抵達日期</label>
        <label class="uk-form-label" for="form-stacked-text" v-else>離開日期</label>
        <div class="uk-form-controls">
            <FlatPickr v-model="date" class="uk-input" :config="flatPickrDateConfig"></FlatPickr>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-text" v-if="type === 'late'">抵達時間</label>
        <label class="uk-form-label" for="form-stacked-text" v-else>離開時間</label>
        <div class="uk-form-controls">
            <FlatPickr v-model="time" class="uk-input" :config="flatPickrTimeConfig"></FlatPickr>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-text" v-if="type === 'late'">遲到原因</label>
        <label class="uk-form-label" for="form-stacked-text" v-else>早退原因</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" rows=5 id="form-stacked-text"
                   v-model="reason" placeholder="給個好理由吧..."></textarea>
        </div>
    </div>

    <div class="uk-margin">
      <button class="uk-button uk-button-primary uk-modal-close" @click="selected">送出</button>
    </div>
  </form>
</div>
</template>

<script>
import FlatPickr from 'vue-flatpickr-component';
import moment from 'moment';
import Multiselect from '../Shared/MultiSelect';


export default {
  props: {
    attendeesOption: {
      type: Array,
      default() { return []; },
    },
    type: {
      validator(value) {
        return ['late', 'leaveEarly'].indexOf(value) !== -1;
      },
    },
    mode: {
      validator(value) {
        return ['new', 'edit'].indexOf(value) !== -1;
      },
    },
    attendee: Object,
    meeting: Object,
  },
  components: {
    Multiselect,
    FlatPickr,
  },
  watch: {
    attendee() {
      this.attendeeValue = this.attendee;
      let dateTime = moment(this.type === 'late' ? this.attendee.arrive_time : this.attendee.leave_time);
      if (!dateTime.isValid()) dateTime = moment();
      this.time = dateTime.format('HH:mm');
      this.date = moment(this.meeting.start_time).format('YYYY-MM-DD');
      this.reason = this.type === 'late' ? this.attendee.late_reason : this.attendee.leave_early_reason;
    },
  },
  data() {
    return {
      flatPickrDateConfig: {
        disable: [{
          from: '0000-00-00',
          to: moment(this.meeting.start_time).subtract(1, 'day').format('YYYY-MM-DD'),
        }],
      },
      flatPickrTimeConfig: {
        enableTime: true,
        noCalendar: true,
        minuteIncrement: 1,
      },
      attendeeValue: null,
      date: '',
      time: '',
      reason: '',
    };
  },
  methods: {
    selected() {
      if (!!this.date && !!this.time && !_.isEmpty(this.attendeeValue)) {
        const time = moment(this.time, 'HH:mm');
        const date = moment(this.date);
        this.$emit(
          'selected',
          this.attendeeValue.user_id,
          moment().set({
            year: date.year(),
            month: date.month(),
            day: date.day(),
            hour: time.hour(),
            minute: time.minute(),
            second: time.second(),
          }).format('YYYY-MM-DD HH:mm:ss'),
          this.reason,
        );
      }
    },
  },
};
</script>
