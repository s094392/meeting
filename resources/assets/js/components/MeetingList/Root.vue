<template>
<div uk-grid>
  <div class="uk-width-3-4@l">
    <h2 class="uk-display-inline">所有會議</h2>
    <button class="uk-button uk-button-primary uk-align-right uk-hidden@l"
            uk-toggle="target: #meeting-filter">篩選器</button>
    <div class="uk-card uk-card-default uk-overflow-auto uk-width-1-1 uk-margin-top">
      <MeetingTable :meetings="meetings"></MeetingTable>
    </div>
    <ul class="uk-pagination uk-flex-center" uk-margin>
      <li v-if="page !== 1">
        <router-link :to="{ name: 'list', query: queryChangePage(1) }">
          <span class="uk-icon">
            <svg class="svg-fix" width="7" height="12"
              viewBox="0 0 7 12" xmlns="http://www.w3.org/2000/svg">
              <polyline fill="none" stroke="#000" stroke-width="1" points="6 1 1 6 6 11">
              </polyline>
            </svg><svg class="svg-fix" width="7" height="12" viewBox="0 0 7 12" xmlns="http://www.w3.org/2000/svg">
              <polyline fill="none" stroke="#000" stroke-width="1" points="6 1 1 6 6 11">
            </polyline>
            </svg>
          </span>
        </router-link>
      </li>
      <template v-for="idx in pageRange()">
        <li :key="idx" >
          <router-link :to="{ name: 'list', query: queryChangePage(idx)}">{{idx}}</router-link>
        </li>
      </template>
      <li v-if="page !== lastPage">
        <router-link :to="{ name: 'list', query: queryChangePage(lastPage) }">
          <span class="uk-icon">
            <svg class="svg-fix" width="7" height="12"
              viewBox="0 0 7 12" xmlns="http://www.w3.org/2000/svg">
              <polyline fill="none" stroke="#000" stroke-width="1" points="1 1 6 6 1 11">
              </polyline>
            </svg><svg class="svg-fix" width="7" height="12" viewBox="0 0 7 12" xmlns="http://www.w3.org/2000/svg">
              <polyline fill="none" stroke="#000" stroke-width="1" points="1 1 6 6 1 11">
            </polyline>
            </svg>
          </span>
        </router-link>
      </li>
    </ul>
  </div>

  <div class="uk-width-1-4@l uk-visible@l">
    <h4>篩選器</h4>
    <div class="uk-card uk-card-body uk-card-small uk-card-default" uk-sticky="offset: 40;">
      <MeetingFilter :query="query" :groupOptions="groupOptions"
                     :ownerOptions="ownerOptions"/>
    </div>
  </div>

  <div id="meeting-filter" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
      <button class="uk-modal-close-default" type="button" uk-close></button>
      <h4>篩選器</h4>
      <MeetingFilter :query="query" :groupOptions="groupOptions"
                     :ownerOptions="ownerOptions"/>
    </div>
  </div>
</div>
</template>

<style lang="scss" scoped>
.svg-fix {
  padding-bottom: 2px;
}
</style>


<script>
import MeetingFilter from './MeetingFilter';
import MeetingTable from '../Shared/MeetingTable';

export default {
  created() {
    this.fetchTas();
  },
  components: {
    MeetingFilter,
    MeetingTable,
  },
  data() {
    return {
      meetings: [],
      groupOptions: [],
      ownerOptions: [],
      lastPage: 1,
    };
  },
  computed: {
    query() {
      return this.$route.query;
    },
    page() {
      return parseInt(this.$route.query.page, 10);
    },
  },
  beforeRouteEnter(to, from, next) {
    const params = to.query;
    if (!params.page) params.page = 1;
    axios.get('/api/meetings', { params }).then((response) => {
      next(vm => vm.setData(response.data));
    });
  },
  beforeRouteUpdate(to, from, next) {
    const params = to.query;
    if (!params.page) params.page = 1;
    axios.get('/api/meetings', { params }).then((response) => {
      this.setData(response.data);
      next();
    });
  },
  methods: {
    queryChangePage(page) {
      return Object.assign({}, this.query, { page });
    },
    setData(data) {
      this.lastPage = parseInt(data.last_page, 10);
      this.meetings = data.data;
    },
    pageRange() {
      let start = this.page - 3;
      let end = this.page + 3;
      if (start <= 0) {
        end += Math.abs(start - 1);
        start = 1;
      }
      if (end > this.lastPage) {
        start -= Math.abs(end - this.lastPage);
        end = this.lastPage;
      }
      return _.range(Math.max(1, start), end + 1);
    },
    fetchTas() {
      axios.get('api/tas').then((response) => {
        this.groupOptions = Object.keys(response.data);
      });
      axios.get('api/users').then((response) => {
        this.ownerOptions = response.data;
      });
    },
  },
};
</script>
