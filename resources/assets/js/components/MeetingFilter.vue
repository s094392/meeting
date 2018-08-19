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
				<DatePicker v-model="time1" :first-day-of-week="1"></DatePicker>
			</div>

			<div class="uk-margin">
				<DatePicker v-model="time1" :first-day-of-week="1"></DatePicker>
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
import DatePicker from "vue2-datepicker";

export default {
  components: { DatePicker },
  data() {
    return {
      time1: "",
      time2: "",
      time3: "",
      shortcuts: [
        {
          text: "今天",
          onClick: () => {
            this.time3 = [new Date(), new Date()];
          }
        }
      ],
      timePickerOptions: {
        start: "00:00",
        step: "00:30",
        end: "23:30"
      }
    };
  }
};
</script>
