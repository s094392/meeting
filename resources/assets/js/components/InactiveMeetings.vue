<template>
  <div>
    <h4>已結束的會議</h4>
    <InactiveMeetingCard v-for="n in 5" :key="n"/>
    <div class="uk-text-right uk-margin-left">
      <a href="#">顯示更多</a>
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
