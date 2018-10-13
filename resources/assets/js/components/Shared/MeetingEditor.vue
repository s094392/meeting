<template>
<div uk-grid>
  <div class="uk-width-3-4@l">
    <span class="page-title" v-if="editMode">編輯會議</span>
    <span class="page-title" v-else>新增會議</span>
    <div class="uk-card uk-card-default uk-card-body uk-card-small">
      <form v-on:submit.prevent class="uk-form-horizontal uk-margin-large">

      <div class="uk-margin">
      <label class="uk-form-label" for="form-horizontal-text">會議名稱</label>
      <div class="uk-form-controls">
        <input v-model="meeting.title" class="uk-input"
        :class="{'form-danger': !meeting.title && triedPost}" type="text" placeholder="輸入會議名稱...">
      </div>
      </div>

      <div class="uk-margin">
      <label class="uk-form-label" for="form-horizontal-text">會議組別</label>
      <div class="uk-form-controls">
        <multiselect class="multi-select" v-model="meeting.group" placeholder="選擇會議組別..."
        :class="{'form-danger': !meeting.group && triedPost}" :options="groupOptions" >
          <span slot="noResult">查無資料</span>
        </multiselect>
      </div>
      </div>

      <div class="uk-margin" v-if="!editMode || meeting.status == $meetingStatus.Init">
        <label class="uk-form-label" for="form-horizontal-text">預計開會時間</label>
        <div class="uk-form-controls">
          <FlatPickr v-model="meeting.scheduled_time" :config="flatPickrConfig"
          class="uk-input" placeholder="選擇開會時間..."
          :class="{'form-danger': !meeting.scheduled_time && triedPost}" >
          </FlatPickr>
        </div>
      </div>

      <div class="uk-margin">
      <label class="uk-form-label" for="form-horizontal-text">
        參與人員
        <a href="#" class="uk-icon-link" uk-icon="icon: trash; ratio: 0.8"
        @click="meeting.attendees=[]"></a>
      </label>
      <div class="uk-form-controls">
        <Multiselect class="multi-select" v-model="meeting.attendees" @input="attendeeSelected"
              placeholder="選擇參與人員..." :options="attendeeOptions"
              :hideSelected="true" :multiple="true" :closeOnSelect="false"
              :trackBy="'user_id'" :label="'username'"
              :class="{'form-danger': meeting.attendees.length == 0 && triedPost}">
          <span slot="noResult">查無資料</span>
        </MultiSelect>
      </div>
      </div>

      <div class="uk-margin">
      <label class="uk-form-label" for="form-horizontal-text">會議說明</label>
        <div class="uk-form-controls">
        <textarea v-model="meeting.description" class="uk-textarea" rows="10" placeholder="會議說明..."
        :class="{'form-danger': !meeting.description && triedPost}"></textarea>
        </div>
      </div>

      <div class="uk-margin uk-align-right">
        <span class="uk-margin-right uk-margin-small-bottom request-money"
             uk-tooltip="若取消勾選擇則本次咪挺不計薪">
          <input class="uk-checkbox"  v-model="meeting.request_money" type="checkbox"> 報帳
        </span>
      <button @click="postMeeting(true)" v-if="editMode"
              class="uk-button uk-button-primary uk-margin-small-bottom">儲存，並寄信通知</button>
      <button @click="postMeeting(false)"
              class="uk-button uk-button-primary uk-margin-small-bottom">
        <span v-if="editMode">僅</span>儲存
      </button>
      </div>
      </form>
    </div>
  </div>
</div>
</template>

<style scoped>
.multi-select {
  transition: border 0.2s ease-in-out;
  border: 1px solid transparent;
}
.form-danger {
  border: 1px solid #f0506e;
}
@media only screen and (max-width: 640px) {
  .request-money {
    display: block;
  }
}

</style>

<script>
import FlatPickr from 'vue-flatpickr-component';
import moment from 'moment';
import last from 'lodash/last';
import uniqBy from 'lodash/uniqBy';
import Multiselect from './MultiSelect';

export default {
  data() {
    return {
      editMode: !!this.$route.params.id,
      meeting: {
        attendees: [],
        request_money: true,
      },
      groupedTas: {},
      triedPost: false,
      groupOptions: [],
      attendeeOptions: [],
      flatPickrConfig: {
        enableTime: true,
        disable: [{
          from: '0000-00-00',
          to: moment().subtract(1, 'day').format('YYYY-MM-DD'),
        }],
      },
    };
  },
  components: {
    Multiselect,
    FlatPickr,
  },
  created() {
    this.fetchTAs();
  },
  beforeRouteEnter(to, from, next) {
    if (to.name === 'create') next();
    else {
      axios.get(`/api/meetings/${to.params.id}`).then((response) => {
        next(vm => vm.setData(response.data));
      });
    }
  },
  methods: {
    fetchTAs() {
      axios.get('/api/tas').then((response) => {
        this.groupedTas = response.data;
        this.groupOptions = Object.keys(this.groupedTas);
        this.groupOptions.forEach(group => this.attendeeOptions.push({
          username: group,
          user_id: group,
          type: 'group',
        }));
        this.attendeeOptions = this.attendeeOptions.concat(response.data['cs-ta']);
      });
    },
    setData(data) {
      this.meeting = data;
    },
    attendeeSelected(selectedOption) {
      const selected = last(selectedOption);
      if (selected.type === 'group') {
        this.meeting.attendees.pop();
        this.meeting.attendees = this.meeting.attendees.concat(
          this.groupedTas[selected.username],
        );
        this.meeting.attendees = uniqBy(this.meeting.attendees, 'user_id');
      }
    },
    postMeeting(email = false) {
      this.triedPost = true;
      if (
        !!this.meeting.title
        && !!this.meeting.description
        && !!this.meeting.group
        && !!this.meeting.scheduled_time
        && this.meeting.attendees.length > 0
      ) {
        this.$store.commit('startLoad');
        axios({
          method: this.editMode ? 'put' : 'post',
          url: this.editMode ? `/api/meetings/${this.$route.params.id}` : '/api/meetings',
          params: { email: this.editMode ? email : true },
          data: this.meeting,
        }).then((response) => {
          this.$store.commit('endLoad');
          this.$router.push({
            name: 'detail',
            params: { id: response.data.id, view: 'properties' },
          });
        });
      }
    },
  },
};
</script>
