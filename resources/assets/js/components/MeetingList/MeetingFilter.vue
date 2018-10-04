<template>
<div>
  <form @submit.prevent>
    <fieldset class="uk-fieldset">
      <div class="uk-margin">
        <input v-model="localQuery.title" class="uk-input" type="text" placeholder="會議名稱">
      </div>

      <div class="uk-margin">
        <Multiselect v-model="localQuery.group" :options="groupOptions"
          v-if="!objectEmpty(groupOptions)" placeholder="任何會議類別">
          <span slot="noResult">查無資料</span>
        </MultiSelect>
        <span v-else class="uk-input input-loading">載入會議類別中...</span>
      </div>

      <div class="uk-margin">
        <FlatPickr v-model="dateRange" :config="config" placeholder="會議日期"></FlatPickr>
      </div>


      <div class="uk-margin">
        <Multiselect v-model="owner" :label="'username'" :trackBy="'id'"
                     :options="ownerOptions" placeholder="任何發起人"
                     v-if="!objectEmpty(ownerOptions)">
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
        @click="$router.push({name: 'list', query: localQuery})">搜尋</button>
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
      if (this.owner && this.owner.id) this.localQuery.owner_id = this.owner.id;
    },
    ownerOptions() {
      this.owner = this.ownerOptions.find(
        owner => owner.id === parseInt(this.localQuery.owner_id, 10),
      );
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
    this.localQuery.page = 1;
    this.dateRange = `${this.query.startDate} to ${this.query.endDate}`;
    this.owner = this.ownerOptions.find(
      owner => owner.id === parseInt(this.localQuery.owner_id, 10),
    );
  },
  methods: {
    clear() {
      this.dateRange = '';
      this.owner = {};
      this.localQuery = {};
      this.$router.push({ name: 'list' });
    },
    objectEmpty(o) {
      return _.isEmpty(o);
    },
  },
  components: {
    FlatPickr,
    Multiselect,
  },
};
</script>
