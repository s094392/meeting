<template>
<div uk-grid>
  <div class="uk-width-3-4@l">
    <h2>{{ meeting.title }}</h2>
    <div class="uk-card uk-card-default uk-card-body uk-card-small">
      
      <ul uk-tab>
        <li :class="{'uk-active': view == 'properties'}" @click="view = 'properties'">
          <router-link :to="{name:'detail', params: {id: id, view: 'properties'}}" replace="">
            <span class="uk-text-large uk-text-lead">會議資料</span>
          </router-link>
        </li>
        <li :class="{'uk-active': view == 'attendees'}" @click="view = 'attendees'">
          <router-link :to="{name:'detail', params: {id: id, view: 'attendees'}}" replace="">
            <span class="uk-text-large uk-text-lead">參與人員</span>
          </router-link >
        </li>
        <li :class="{'uk-active': view == 'record'}" @click="view = 'record'">
          <router-link :to="{name:'detail', params: {id: id, view: 'record'}}" replace="">
            <span class="uk-text-large uk-text-lead">會議內容</span>
          </router-link >
        </li>
      </ul>

      <Properties v-show="view == 'properties'" :meeting="meeting" />
      <Attendees v-show="view == 'attendees'" :meeting="meeting" />
      <Record v-show="view == 'record'" :meeting="meeting"/>
    </div>
  </div>

  <div class="uk-width-1-4@l" :class="{'visibility-hidden': view != 'record'}">
    <h4>目錄</h4>
    <div class="uk-card uk-card-small uk-card-default uk-card-body" uk-sticky="offset:40;" id="toc"></div>
  </div>
</div>

</template>

<style lang="scss">
#toc {
  max-height: 85vh;
  overflow: auto;
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
