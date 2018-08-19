<template>
  <div>
    <div>
      <h2 class="uk-display-inline">近期會議</h2>
      <button class="uk-button uk-button-primary uk-align-right">新增會議</button>
    </div>
    <ActiveMeetingCard v-for="n in 4" :key="n"/>
  </div>
</template>

<script>
import ActiveMeetingCard from "./ActiveMeetingCard";

export default {
  components: {
    ActiveMeetingCard
  }
};
</script>
