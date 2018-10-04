<template>
<div>
  <div class="progress" v-show="loading">
    <div class="indeterminate"></div>
  </div>
  <TopNav />
  <div class="uk-padding">
    <div uk-grid>
      <div class="uk-width-1-5@m"><LeftNav/></div>
      <div class="uk-width-4-5@m">
        <router-view></router-view>
      </div>
    </div>
  </div>
</div>
</template>

<style lang="scss" scoped>
@media only screen and (max-width: 640px) {
  .uk-padding {
    padding: 15px;
  }
}
</style>


<script>
import { mapState } from 'vuex';
import LeftNav from './components/Shared/LeftNav';
import TopNav from './components/Shared/TopNav';


export default {
  name: 'App',
  components: {
    LeftNav,
    TopNav,
  },
  computed: mapState(['loading']),
};
</script>
