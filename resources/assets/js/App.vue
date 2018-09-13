<template>
<div v-if="loaded">
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
    padding-top: 15px;
  }
}
</style>


<script>
import LeftNav from './components/Shared/LeftNav';
import TopNav from './components/Shared/TopNav';

export default {
  name: 'App',
  components: {
    LeftNav,
    TopNav,
  },
  data() {
    return {
      loaded: false,
    };
  },
  created() {
    this.initUser();
  },
  methods: {
    initUser() {
      this.$store.dispatch('initUser').then(() => {
        this.loaded = true;
      });
    },
  },
};
</script>
