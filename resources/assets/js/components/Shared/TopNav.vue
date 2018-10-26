<template>
 <div class="uk-hidden@m" uk-sticky="show-on-up: true; animation: uk-animation-slide-top;
 sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: #scrollup-dropbar">
  <nav class="uk-navbar-container" uk-navbar="mode: click">
    <div class="uk-container-expand">
      <div uk-navbar="dropbar: true; dropbar-anchor: !.uk-navbar-container; duration:150">
        <div class="uk-navbar-left">
          <ul class="uk-navbar-nav">
            <li>
            <a class="uk-navbar-toggle uk-margin-left" href="#">
              <span uk-navbar-toggle-icon></span>
              <span class="uk-margin-small-left">Menu</span>
            </a>
            <div ref="dropdown" class="uk-navbar-dropdown uk-padding-small">
              <ul class="uk-nav uk-navbar-dropdown-nav">
                <li><a @click="$router.push({name: '/'})" href="#">首頁</a></li>
                <li>
                  <a @click="$router.push({name :'list',  params: { page: 1 } })" href="#">會議列表</a>
                </li>
                <li><a @click="$router.push({name :'profileRedirect'})" href="#">個人報表</a></li>
                <li>
                  <a @click="$router.push({ name :'manual' })" href="#">使用手冊</a>
                </li>
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
  <form v-show="false" ref="logoutForm" method="POST" action="https://oauth.cs.nctu.edu.tw/logout"></form>
</div>
</template>

<style lang="scss" scoped>
.uk-navbar-toggle {
  min-height: 60px;
}
</style>


<script>
import { mapState } from 'vuex';

export default {
  computed: mapState(['user']),
  methods: {
    logout() {
      this.$refs.logoutForm.submit();
    },
  },
};
</script>
