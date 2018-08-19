<template>
  <div>
    <div>
      <h2 class="uk-display-inline">近期會議</h2>
      <router-link :to="{name:'new'}" class="uk-button uk-button-primary uk-align-right">新增會議</router-link>
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
