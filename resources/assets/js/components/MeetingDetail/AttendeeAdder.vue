<template>
<div class="uk-modal-dialog uk-modal-body">
  <h2 class="uk-modal-title" v-if="type === 'late'">新增遲到成員</h2>
  <h2 class="uk-modal-title" v-else>新增早退成員</h2>
  <div class="uk-form-stacked">

    <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-text">ID</label>
        <div class="uk-form-controls">
            <Multiselect v-model="attendeeValue" :options="attendees.map(a => a.user_id)"></MultiSelect>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-text" v-if="type === 'late'">抵達時間</label>
        <label class="uk-form-label" for="form-stacked-text" v-else>離開時間</label>
        <div class="uk-form-controls">
            <FlatPickr v-model="time" :config="flatPickrConfig"></FlatPickr>
        </div>
    </div>
  
    <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-text" v-if="type === 'late'">遲到原因</label>
        <label class="uk-form-label" for="form-stacked-text" v-else>早退原因</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="form-stacked-text" type="text" v-model="reason" placeholder="Some text...">
        </div>
    </div>

    <div class="uk-margin">
      <button class="uk-button uk-button-primary uk-modal-close" @click="selected">送出</button>
    </div>

</div>
</div>
</template>

<style lang="scss" scoped>
.flatpickr-input {
  display: none;
}
</style>


<script>
import Multiselect from "vue-multiselect";
import FlatPickr from "vue-flatpickr-component";

export default {
  props: ["attendees", "type"],
  components: {
    Multiselect,
    FlatPickr
  },
  data() {
    return {
      flatPickrConfig: {
        enableTime: true,
        noCalendar: true,
        inline: true
      },
      attendeeValue: null,
      reason: "",
      time: new Date().toTimeString().split(" ")[0]
    };
  },
  methods: {
    selected: function() {
      this.$emit("selected", this.attendeeValue, this.time, this.reason);
      this.time = new Date().toTimeString().split(" ")[0];
      this.attendeeValue = null;
      this.reason = "";
    }
  }
};
</script>
