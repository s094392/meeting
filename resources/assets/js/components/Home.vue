<template>
<div uk-grid>
    <div class="uk-width-3-4@m">
        <ActiveMeetings/>
    </div>
    <div class="uk-width-1-4@m">
        <InactiveMeetings/>
    </div>
</div>
</template>

<script>
import ActiveMeetings from "./ActiveMeetings";
import InactiveMeetings from "./InactiveMeetings";
export default {
  components: {
    ActiveMeetings,
    InactiveMeetings
  }
};
</script>
