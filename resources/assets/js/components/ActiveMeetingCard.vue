<template>
<div>
    <div class="uk-card uk-card-default uk-card-body uk-card-hover uk-margin-top">
      <div>
        <span class="uk-card-title">WWW 新生訓練</span>
        <span class="uk-label uk-align-right">Badge</span>
      </div>
        <p>
          <span class="uk-margin-small-right" uk-icon="user"/>blzhuang<br>
          <span class="uk-margin-small-right" uk-icon="tag"/>www<br>
          <span class="uk-margin-small-right" uk-icon="clock"/>2018-08-17 13:35
        </p>
        <p>他媽的新生給我來喔<br></p>
        <MeetingControl />
    </div>
</div>
</template>


<script>
import MeetingControl from "./MeetingControl";

export default {
  components: {
    MeetingControl
  }
};
</script>
