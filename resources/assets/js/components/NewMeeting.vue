<template>
<div uk-grid>
  <div class="uk-width-3-4@m">
    <h2>新增會議</h2>
    <div class="uk-card uk-card-default uk-card-body uk-card-small">
      <form class="uk-form-horizontal uk-margin-large">

      <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-text">會議名稱</label>
        <div class="uk-form-controls">
          <input class="uk-input" id="form-horizontal-text" type="text" placeholder="請輸入會議名稱...">
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-text">會議類別</label>
        <div class="uk-form-controls">
          <multiselect v-model="categoryValue" :options="categoryOptions" ></multiselect>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-text">開會日期</label>
        <div class="uk-form-controls">
          <FlatPickr v-model="dateTime" :config="config"></FlatPickr>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-text">參與人員</label>
        <div class="uk-form-controls">
          <Multiselect v-model="attendeeValue" :options="attendeeOptions"  :multiple="true"></MultiSelect>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-text">會議說明</label>
          <div class="uk-form-controls">
            <textarea class="uk-textarea" rows="10" placeholder="Textarea"></textarea>
          </div>
      </div>

      <div class="uk-margin uk-align-right">
        <button class="uk-button uk-button-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
</template>


<script>
import Multiselect from "vue-multiselect";
import FlatPickr from "vue-flatpickr-component";

export default {
  data() {
    return {
      dateTime: null,
      categoryValue: "",
      categoryOptions: ["www", "linux"],
      timeValue: null,
      timeOptions: ["10:00", "10:15"],
      attendeeValue: null,
      attendeeOptions: ["Linux", "mllee", "calee"],
      config: {
        enableTime: true
      }
    };
  },
  components: {
    Multiselect,
    FlatPickr
  }
};
</script>
