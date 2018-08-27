<template>
<div>
  <div class="uk-card uk-card-default uk-card-body uk-margin-top">
    <div>
      <router-link :to="{name:'detail', params: {id: meeting.id, view: 'properties'}}" class="uk-card-title">{{ meeting.title }}</router-link>
      <span v-if="meeting.status == 'Started'" class="uk-label uk-align-right">會議進行中</span>
    </div>
    <p>
      <span class="uk-margin-small-right" uk-icon="user" />{{ meeting.owner }}<br>
      <span class="uk-margin-small-right" uk-icon="tag" />{{ meeting.group }}<br>
      <span class="uk-margin-small-right" uk-icon="clock" />{{ meeting.scheduled_time }}
    </p>
    <p>{{ meeting.description }}<br></p>
    <MeetingControl :id="meeting.id" :status="meeting.status" v-on:delete="$emit('delete', meeting.id);"/>
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
