<template>
<div uk-grid>
  <div class="uk-width-3-4@l">
  <h2 v-if="editMode">編輯會議</h2>
  <h2 v-else>新增會議</h2>
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
      :class="{'form-danger': !meeting.group && triedPost}" :options="groupOptions" ></multiselect>
    </div>
    </div>

    <div class="uk-margin" v-if="!editMode || meeting.status == $meetingStatus.Init">
      <label class="uk-form-label" for="form-horizontal-text">預計開會時間</label>
      <div class="uk-form-controls">
        <FlatPickr v-model="meeting.scheduled_time" :config="flatPickrConfig"
        class="flatpickr-input" placeholder="選擇開會時間..."
        :class="{'form-danger': !meeting.scheduled_time && triedPost}" >
        </FlatPickr>
      </div>
    </div>

    <div class="uk-margin">
    <label class="uk-form-label" for="form-horizontal-text">參與人員</label>
    <div class="uk-form-controls">
      <Multiselect class="multi-select" v-model="meeting.attendees" @input="attendeeSelected"
            placeholder="選擇參與人員..." :options="attendeeOptions"
            :hideSelected="true" :multiple="true" :closeOnSelect="false"
            :trackBy="'user_id'" :label="'username'"
            :class="{'form-danger': meeting.attendees.length == 0 && triedPost}"></MultiSelect>
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
    <button @click="postMeeting" class="uk-button uk-button-primary">送出</button>
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
</style>

<script>
import Multiselect from 'vue-multiselect';
import FlatPickr from 'vue-flatpickr-component';
import moment from 'moment';

export default {
  data() {
    return {
      editMode: !!this.$route.params.id,
      meeting: {
        attendees: [],
      },
      groupedTas: {},
      triedPost: false,
      groupOptions: [],
      attendeeOptions: [],
      flatPickrConfig: {
        enableTime: true,
        disable: [{
          from: '0000-00-00',
          to: moment().format('YYYY-MM-DD'),
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
    if (this.editMode) {
      this.fetchMeeting();
    }
  },
  methods: {
    fetchTAs() {
      axios.get('/api/tas/grouped').then((response) => {
        this.groupedTas = response.data;
        this.groupOptions = Object.keys(this.groupedTas);
        this.groupOptions.forEach(group => this.attendeeOptions.push({
          username: group,
          user_id: group,
          type: 'group',
        }));
        Object.values(this.groupedTas).forEach((tas) => {
          this.attendeeOptions = this.attendeeOptions.concat(tas);
        });
        this.attendeeOptions = _.uniqBy(this.attendeeOptions, 'user_id');
      });
    },
    fetchMeeting() {
      axios.get(`/api/meeting/${this.$route.params.id}`).then((response) => {
        this.meeting = response.data;
      });
    },
    attendeeSelected(selectedOption) {
      const selected = _.last(selectedOption);
      if (selected.type === 'group') {
        this.meeting.attendees.pop();
        this.meeting.attendees = this.meeting.attendees.concat(
          this.groupedTas[selected.username],
        );
        this.meeting.attendees = _.uniqBy(this.meeting.attendees, 'user_id');
      }
    },
    postMeeting() {
      this.triedPost = true;
      if (
        !!this.meeting.title
        && !!this.meeting.description
        && !!this.meeting.group
        && !!this.meeting.scheduled_time
        && !!this.meeting.attendees
      ) {
        axios({
          method: this.editMode ? 'put' : 'post',
          url: this.editMode ? `/api/meeting/${this.$route.params.id}` : '/api/meeting',
          data: this.meeting,
        }).then((response) => {
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
