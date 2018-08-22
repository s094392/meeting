<template>
<div>
  <div class="uk-card uk-card-default uk-card-body uk-margin-top">
    <div>
      <router-link :to="{name:'detail', params: {id: meeting.id, view: 'properties'}}" class="uk-card-title">{{ meeting.title }}</router-link>
      <span class="uk-label uk-align-right">Badge</span>
    </div>
    <p>
      <span class="uk-margin-small-right" uk-icon="user" />{{ meeting.owner }}<br>
      <span class="uk-margin-small-right" uk-icon="tag" />{{ meeting.team }}<br>
      <span class="uk-margin-small-right" uk-icon="clock" />{{ meeting.scheduled_time }}
    </p>
    <p>{{ meeting.description }}<br></p>
    <MeetingControl :id="meeting.id" v-on:delete="$emit('delete', meeting.id);"/>
  </div>
</div>
</template>


<script>
import MeetingControl from "../Shared/MeetingControl";

export default {
  props: ["meeting"],
  components: {
    MeetingControl
  }
};
</script>
