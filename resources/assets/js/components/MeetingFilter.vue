<template>
<div>
	<form>
		<fieldset class="uk-fieldset">
			<div class="uk-margin">
				<input class="uk-input" type="text" placeholder="會議名稱">
			</div>

			<div class="uk-margin">
				<Multiselect v-model="categoryValue" :options="categoryOptions" placeholder="任何會議類別"></MultiSelect>
			</div>

			<div class="uk-margin">
				<FlatPickr v-model="date" :config="config" placeholder="會議日期"></FlatPickr>
			</div>


			<div class="uk-margin">
				<Multiselect v-model="organizerValue" :options="organizerOptions" placeholder="任何發起人"></MultiSelect>
			</div>

			<div class="uk-margin">
				<select class="uk-select">
					<option>任何狀態</option>
					<option>狀態1</option>
					<option>狀態2</option>
					<option>狀態</option>
				</select>
			</div>

			<button class="uk-button uk-button-primary">搜尋</button>
		</fieldset>
	</form>
</div>
</template>

<style lang="scss" scoped>
.multiselect {
  color: inherit;
}
</style>


<script>
import FlatPickr from "vue-flatpickr-component";
import Multiselect from "vue-multiselect";

export default {
  data() {
    return {
      categoryValue: null,
      categoryOptions: ["www", "NET", "Linux"],
      organizerValue: null,
      organizerOptions: ["tsengcy", "mullee", "weicc", "apple", "banana"],
      date: null,
      config: {
        mode: "range"
      }
    };
  },
  components: {
    FlatPickr,
    Multiselect
  }
};
</script>
