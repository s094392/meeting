<template>
<div>
  <div class="progress" v-if="loading || !init">
    <div class="indeterminate"></div>
  </div>
  <template v-if="init">
    <TopNav />
    <div class="uk-padding">
      <div uk-grid>
        <div class="uk-width-1-5@m"><LeftNav/></div>
        <div class="uk-width-4-5@m">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </template>
</div>
</template>

<style lang="scss" scoped>
@media only screen and (max-width: 640px) {
  .uk-padding {
    padding-top: 15px;
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
  data() {
    return {
      init: false,
    };
  },
  created() {
    this.initUser();
  },
  methods: {
    initUser() {
      this.$store.dispatch('initUser').then(() => {
        this.loaded = true;
        this.init = true;
      });
    },
  },
};
</script>
