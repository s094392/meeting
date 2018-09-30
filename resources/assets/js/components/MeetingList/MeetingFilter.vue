<template>
<div>
  <form @submit.prevent>
    <fieldset class="uk-fieldset">
      <div class="uk-margin">
        <input v-model="localQuery.title" class="uk-input" type="text" placeholder="會議名稱">
      </div>

      <div class="uk-margin">
        <Multiselect v-model="localQuery.group" :options="groupOptions"
          v-if="groupOptions" placeholder="任何會議類別">
          <span slot="noResult">查無資料</span>
        </MultiSelect>
        <span v-else class="uk-input input-loading">載入會議類別中...</span>
      </div>

      <div class="uk-margin">
        <FlatPickr v-model="dateRange" :config="config" placeholder="會議日期"></FlatPickr>
      </div>


      <div class="uk-margin">
        <Multiselect v-model="owner" :label="'username'" :trackBy="'user_id'"
                     :options="ownerOptions" placeholder="任何發起人"
                     v-if="ownerOptions">
          <span slot="noResult">查無資料</span>
        </MultiSelect>
        <span v-else class="uk-input input-loading">載入發起人資料中...</span>
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
.input-loading {
  color: #999;
}
</style>


<script>
import FlatPickr from 'vue-flatpickr-component';
import Multiselect from '../Shared/MultiSelect';

export default {
  props: ['groupOptions', 'ownerOptions', 'query'],
  watch: {
    dateRange() {
      if (this.dateRange && this.dateRange !== 'undefined to undefined') {
        [this.localQuery.startDate, this.localQuery.endDate] = this.dateRange.split(' to ');
      }
    },
    owner() {
      if (this.owner && this.owner.user_id) this.localQuery.owner = this.owner.user_id;
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
