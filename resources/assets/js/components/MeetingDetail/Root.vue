<template>
<div uk-grid>
  <div class="uk-width-3-4@m">
    <h2>{{ meeting.title }}</h2>
    <div class="uk-card uk-card-default uk-card-body uk-card-small">
      <ul uk-tab>
        <li :class="{'uk-active': view == 'data'}" @click="view = 'data'">
          <router-link :to="{name:'detail', params: {id: id, view: 'data'}}" replace="">
            <span class="uk-text-large uk-text-lead">會議資料</span>
          </router-link>
        </li>
        <li :class="{'uk-active': view == 'attendees'}" @click="view = 'attendees'">
          <router-link :to="{name:'detail', params: {id: id, view: 'attendees'}}" replace="">
            <span class="uk-text-large uk-text-lead">參與人員</span>
          </router-link >
        </li>
        <li :class="{'uk-active': view == 'content'}" @click="view = 'content'">
          <router-link :to="{name:'detail', params: {id: id, view: 'content'}}" replace="">
            <span class="uk-text-large uk-text-lead">會議內容</span>
          </router-link >
        </li>
      </ul>

      <Properties v-show="view == 'data'" :meeting="meeting" />
      <Attendees v-show="view == 'attendees'" :meeting="meeting" />
      <Record v-show="view == 'content'" :meeting="meeting" :aa="aa"/>
    </div>
  </div>

  <div class="uk-width-1-4@m" :class="{'visibility-hidden': view != 'content'}">
    <h4>目錄</h4>
    <div class="uk-card uk-card-small uk-card-default uk-card-body" uk-sticky="offset:40;" id="toc"></div>
  </div>
</div>

</template>

<style lang="scss">
.disabled-normal-color {
  color: #333 !important;
}
</style>


<script>
import Properties from "./Properties";
import Attendees from "./Attendees";
import Record from "./Record";

export default {
  created() {
    this.fetchMeeting();
  },
  data: function() {
    return {
      id: this.$route.params.id,
      view: this.$route.params.view,
      meeting: {}
    };
  },
  components: {
    Properties,
    Attendees,
    Record
  },
  methods: {
    fetchMeeting: function() {
      axios.get("/api/meeting/" + this.id).then(response => {
        this.meeting = response.data;
      });
    }
  }
};
</script>
