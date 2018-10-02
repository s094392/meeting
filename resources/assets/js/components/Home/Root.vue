<template>
<div uk-grid>
  <div class="uk-width-3-4@l">
    <div>
      <div>
        <h2 class="uk-display-inline">近期會議</h2>
        <router-link :to="{name:'create'}"
                   class="uk-button uk-button-primary uk-align-right">
          新增會議
        </router-link>
      </div>
      <template v-if="activeMeetings">
        <div v-if="activeMeetings.length === 0" class="uk-text-large uk-text-lead uk-margin-top">
          無資料
        </div>
        <template v-else>
          <ActiveMeetingCard v-for="meeting in activeMeetings"
                          :key="meeting.id" :meeting="meeting"/>
        </template>
      </template>
    </div>
  </div>
    <div class="uk-width-1-4@l">
        <InactiveMeetings/>
    </div>
</div>
</template>

<script>
import ActiveMeetingCard from './ActiveMeetingCard';
import InactiveMeetings from './InactiveMeetings';
import MeetingEnum from '../../MeetingEnum';

export default {
  components: {
    ActiveMeetingCard,
    InactiveMeetings,
  },
  data() {
    return {
      activeMeetings: null,
    };
  },
  beforeRouteEnter(to, from, next) {
    axios.get('/api/meetings', {
      params: {
        status: [MeetingEnum.meetingStatus.Init,
          MeetingEnum.meetingStatus.Start],
      },
    }).then((response) => {
      next(vm => vm.setData(response.data.data));
    });
  },
  methods: {
    setData(data) {
      this.activeMeetings = data;
    },
  },
};
</script>
