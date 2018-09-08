<template>
<div>
	<form @submit.prevent>
		<fieldset class="uk-fieldset">
			<div class="uk-margin">
				<input v-model="title" class="uk-input" type="text" placeholder="會議名稱">
			</div>

			<div class="uk-margin">
				<Multiselect v-model="group" :options="groupOptions" placeholder="任何會議類別"></MultiSelect>
			</div>

			<div class="uk-margin">
				<FlatPickr v-model="date" :config="config" placeholder="會議日期"></FlatPickr>
			</div>


			<div class="uk-margin">
				<Multiselect v-model="owner" :label="'username'" :trackBy="'user_id'" :options="ownerOptions" placeholder="任何發起人"></MultiSelect>
			</div>

			<div class="uk-margin">
				<select class="uk-select" v-model="status">
					<option :value="null">任何狀態</option>
					<option v-for="idx in $meetingStatusText.length - 1" :key="idx" :value="idx">
						{{$meetingStatusText[idx]}}
					</option>
				</select>
			</div>

			<button class="uk-button uk-button-primary uk-modal-close" 
				@click="$emit('search', title, group, startDate, endDate, owner, status)">搜尋</button>
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
  props: ["groupOptions", "ownerOptions"],
  computed: {
    startDate: function() {
      return this.date ? this.date.split(" to ")[0] : null;
    },
    endDate: function() {
      return this.date ? this.date.split(" to ")[1] : null;
    }
  },
  data() {
    return {
      title: null,
      group: null,
      owner: null,
      date: null,
      status: null,
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
