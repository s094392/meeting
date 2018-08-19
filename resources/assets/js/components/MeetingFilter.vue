<template>
<div>
	<h4>篩選器</h4>
	<div class="uk-card uk-card-body uk-card-small uk-card-default">
	<form>
		<fieldset class="uk-fieldset">
			<div class="uk-margin">
				<input class="uk-input" type="text" placeholder="會議名稱">
			</div>

			<div class="uk-margin">
				<select class="uk-select">
					<option>任何分類</option>
					<option>Option 02</option>
				</select>
			</div>

			<div class="uk-margin">
				<FlatPickr v-model="date" :config="config"></FlatPickr>
			</div>


			<div class="uk-margin">
				<input class="uk-input" type="text" placeholder="發起人">
			</div>

			<div class="uk-margin">
				<select class="uk-select">
					<option>任何狀態</option>
					<option>Option 02</option>
				</select>
			</div>

			<button class="uk-button uk-button-primary">搜尋</button>
		</fieldset>
	</form>
	</div>
	</div>
</template>

<script>
import FlatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";

export default {
  data() {
    return {
      date: null,
      config: {
        mode: "range"
      }
    };
  },
  components: {
    FlatPickr
  }
};
</script>
