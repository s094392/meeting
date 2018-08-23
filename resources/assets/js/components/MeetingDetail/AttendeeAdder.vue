<template>
<span>
  <span class="name-tag clickable">
    <span uk-icon="plus"></span>
  </span>
  <div uk-dropdown="mode: click">
    成員: <Multiselect v-model="attendeeValue" :options="attendeeOptions" autofocus></MultiSelect>
    時間: <br/><FlatPickr v-model="time" :config="flatPickrConfig"></FlatPickr>
    <br/>
    <a href="#" class="uk-button uk-button-primary uk-button-small" @click="selected">確定</a>
  </div>
</span>
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
  props: ["attendeeOptions", "status"],
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
      time: new Date()
    };
  },
  methods: {
    selected: function() {
      this.$emit("selected", this.status, this.attendeeValue, this.time);
      this.time = new Date();
      this.attendeeValue = null;
    }
  }
};
</script>
