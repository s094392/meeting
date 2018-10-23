<template>
<div uk-grid v-if="meeting">
  <div class="uk-width-3-4@l">
    <span class="page-title">{{ meeting.title }}</span>
    <div class="uk-card uk-card-default uk-card-body uk-card-small">
      <ul :uk-tab="`active: ${activeTabIndex};`">
        <li>
          <router-link :to="{ name: 'properties' }" replace>
            <span class="uk-text-large">
              <span class="uk-visible@s">會議</span>資料
            </span>
          </router-link>
        </li>
        <li>
          <router-link :to="{ name: 'attendees' }" replace>
            <span class="uk-text-large">
              <span class="uk-visible@s">參與</span>人員
            </span>
          </router-link>
        </li>
        <li>
          <router-link :to="{ name: 'record' }" replace>
            <span class="uk-text-large">
              <span class="uk-visible@s">會議</span>紀錄
            </span>
          </router-link>
        </li>
      </ul>
      <keep-alive>
        <router-view
          :meeting="meeting"
          :me.sync="me"
          :attendees="meeting.attendees"
          @update:attendee="updateAttendee"
          @update:toc="tocHtml = $event">
        </router-view>
      </keep-alive>

      <MeetingControl
        :meeting="meeting"
        :me.sync="me"
        v-if="$route.name === 'properties'"
        @cancelMeeting="$router.replace('/')"
        @startMeeting="meeting = $event"
        @endMeeting="meeting = $event"
        @completeRecord="meeting = $event" />
    </div>
  </div>

  <div
    class="uk-visible@l uk-width-1-4@l"
    v-if="tocHtml && meeting.record && $route.name === 'record'">
    <h4>目錄</h4>
    <div
      class="uk-card uk-card-small uk-card-default uk-card-body toc markdown-body"
      uk-sticky="offset: 40;"
      v-html="tocHtml">
    </div>
  </div>
</div>
</template>

<style lang="scss">
.markdownIt-TOC {
  ul {
    padding-left: 15px;
  }
}
</style>

<style lang="scss" scoped>
.toc {
  max-height: 90vh;
  overflow: auto;
  padding: 20px 10px;
}
@media only screen and (max-width: 640px) {
  .uk-card-small.uk-card-body {
    padding: 15px;
  }
}
</style>


<script>
import { mapState } from 'vuex';
import MeetingControl from '../Shared/MeetingControl';

export default {
  components: { MeetingControl },
  beforeRouteEnter(to, from, next) {
    axios.get(`/api/meetings/${to.params.id}`).then((response) => {
      next(vm => vm.setData(response.data));
    }).catch((error) => {
      if (error.response.status === 404) {
        next(vm => vm.redirect404());
      }
    });
  },
  computed: {
    me: {
      get() {
        const me = this.meeting.attendees.find(
          attendees => attendees.user_id === this.user.user_id,
        );
        return me === undefined ? {} : me;
      },
      set(me) {
        const index = this.meeting.attendees.findIndex(
          attendees => attendees.user_id === this.user.user_id,
        );
        this.$set(this.meeting.attendees, index, me);
      },
    },
    activeTabIndex() {
      return ['properties', 'attendees', 'record'].indexOf(this.$route.name);
    },
    id() {
      return this.$route.params.id;
    },
    ...mapState(['user']),
  },
  data() {
    return {
      meeting: null,
      editingRecord: false,
      tocHtml: '',
    };
  },
  methods: {
    setData(data) {
      this.meeting = data;
      document.title = `${this.meeting.title} - Meeting`;
    },
    redirect404() {
      this.$router.replace('/404');
    },
    updateAttendee(modifiedAttendee) {
      const index = this.meeting.attendees.findIndex(
        attendee => attendee.user_id === modifiedAttendee.user_id,
      );
      this.$set(this.meeting.attendees, index, modifiedAttendee);
    },
  },
};
</script>
