<template>
 <div class="uk-hidden@m" uk-sticky="show-on-up: true; animation: uk-animation-slide-top;
 sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: #scrollup-dropbar">
  <nav class="uk-navbar-container" uk-navbar="mode: click">
    <div class="uk-container-expand">
      <div  class="top-nav"
            uk-navbar="dropbar: true; dropbar-anchor: !.uk-navbar-container; duration:150">
        <div class="uk-navbar-left">
          <ul class="uk-navbar-nav">
            <li>
            <a class="uk-navbar-toggle uk-margin-left" href="#">
              <span uk-navbar-toggle-icon></span>
              <span class="uk-margin-small-left">Menu</span>
            </a>
            <div ref="dropdown" class="uk-navbar-dropdown uk-padding-small">
              <ul class="uk-nav uk-navbar-dropdown-nav">
                <li><a @click="routerPush('/')" href="#">首頁</a></li>
                <li><a @click="routerPush('list')" href="#">會議列表</a></li>
                <li><a href="#">個人報表</a></li>
                <li><a @click="logout">登出</a></li>
              </ul>
            </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="uk-navbar-right uk-margin-right">
      <ul class="uk-navbar-nav">
        <li>{{ user.uid }}</li>
      </ul>
    </div>
  </nav>
</div>
</template>

<style lang="scss" scoped>
.top-nav{
  height: 60px;
}
.uk-navbar-dropdown{
  top: 60px !important;
}
</style>


<script>
import { mapState } from 'vuex';

export default {
  computed: mapState(['user']),
  methods: {
    routerPush(name) {
      this.$router.push({ name });
    },
    logout() {
      axios.post('/logout').then(() => {
        window.location = `${this.$basePath}login`;
      });
    },
  },
};
</script>
