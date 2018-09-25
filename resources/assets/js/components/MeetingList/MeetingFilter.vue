<template>
<div>
  <form @submit.prevent>
    <fieldset class="uk-fieldset">
      <div class="uk-margin">
        <input v-model="localQuery.title" class="uk-input" type="text" placeholder="會議名稱">
      </div>

      <div class="uk-margin">
        <Multiselect v-model="localQuery.group" :options="groupOptions" placeholder="任何會議類別">
        </MultiSelect>
      </div>

      <div class="uk-margin">
        <FlatPickr v-model="dateRange" :config="config" placeholder="會議日期"></FlatPickr>
      </div>


      <div class="uk-margin">
        <Multiselect v-model="owner" :label="'username'" :trackBy="'user_id'"
                     :options="ownerOptions" placeholder="任何發起人"></MultiSelect>
      </div>

      <div class="uk-margin">
        <select class="uk-select" v-model="localQuery.status">
          <option :value="undefined">任何狀態</option>
          <option v-for="idx in $meetingStatusText.length - 1" :key="idx" :value="idx">
            {{$meetingStatusText[idx]}}
          </option>
        </select>
      </div>

      <button class="uk-button uk-button-primary uk-modal-close"
        @click="$router.push({name: 'list', params: { page: 1 } , query: localQuery})">搜尋</button>
      <button class="uk-button uk-button-danger"
              @click="clear">清空</button>
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
import FlatPickr from 'vue-flatpickr-component';
import Multiselect from 'vue-multiselect';

export default {
  props: ['groupOptions', 'ownerOptions', 'query'],
  watch: {
    dateRange() {
      if (this.dateRange && this.dateRange !== 'undefined to undefined') {
        [this.localQuery.startDate, this.localQuery.endDate] = this.dateRange.split(' to ');
      }
    },
    owner() {
      if (this.owner.user_id) this.localQuery.owner = this.owner.user_id;
    },
  },
  data() {
    return {
      config: {
        mode: 'range',
      },
      dateRange: '',
      localQuery: {},
      owner: {},
    };
  },
  created() {
    this.localQuery = Object.assign({}, this.query);
    this.dateRange = `${this.query.startDate} to ${this.query.endDate}`;
    this.owner = this.ownerOptions.find(owner => owner.user_id === this.localQuery.owner);
  },
  methods: {
    clear() {
      this.dateRange = '';
      this.owner = Object.assign({});
      this.localQuery = Object.assign({});
      this.$router.push({ name: 'list', params: { page: 1 } });
    },
  },
  components: {
    FlatPickr,
    Multiselect,
  },
};
</script>
