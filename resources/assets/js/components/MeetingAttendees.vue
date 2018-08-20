<template>
<div>
  <div>
    <h3>準時成員</h3>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>tzuyu</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>ycchang</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>yaowen</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>yahsieh</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>syujy</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>youwei1129</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wwchung</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wangth</button>
    <h3>遲到成員</h3>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>yahsieh</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>syujy</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>youwei1129</button>
    <h3>早退成員</h3>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wwchung</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wangth</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" >
      <span uk-icon="plus"></span>
    </button>
    <div uk-dropdown="mode: click">
      成員: <Multiselect v-model="attendeeValue" :options="attendeeOptions" autofocus></MultiSelect>
      時間: <br/><FlatPickr v-model="time" :config="config"></FlatPickr>
      <br/>
      <br/>
      <br/>
      <a href="#" class="uk-button uk-button-primary uk-button-small">確定</a>
    </div>


    <h3>請假成員</h3>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wwchung</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wangth</button>
    <h3>翹咪成員</h3>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wwchung</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>syujy</button>
    <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>youwei1129</button>
  </div>

</div>
</template>



<script>
import Multiselect from "vue-multiselect";
import FlatPickr from "vue-flatpickr-component";

export default {
  data() {
    return {
      config: {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        static: true
      },
      show: false,
      time: "",
      attendeeValue: null,
      attendeeOptions: ["Linux", "mllee", "calee"]
    };
  },
  components: {
    Multiselect,
    FlatPickr
  }
};
</script>
