<template>
  <div>
    <h4>已結束的會議</h4>
    <InactiveMeetingCard v-for="n in 5" :key="n"/>
    <div class="uk-text-right uk-margin-left">
      <router-link :to="{name:'list'}">顯示更多</router-link>
    </div>
  </div>
</template>

<script>
import InactiveMeetingCard from "./InactiveMeetingCard";

export default {
  components: {
    InactiveMeetingCard
  }
};
</script>
