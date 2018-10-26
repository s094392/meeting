<template>
<div class="uk-visible@m">
  <div class="uk-margin-left" uk-sticky="offset: 40;">
    <div>
      <div class="uk-margin-bottom">
        <img :src="$basePath + 'img/meeting.png'" class="logo uk-margin-small-right">
        <span class="uk-text-large uk-text-bold">Meeting</span>
      </div>
      <ul class="uk-nav uk-nav-default uk-nav-primary">
        <li>
          <span class="uk-text-large uk-text-lead uk-text-capitalize">
          {{ user.username }}
          </span>
          {{ user.chinese_name }}
          </li>
        <li class="uk-nav-divider"></li>
        <li>
          <router-link :to="{ name: '/'}">首頁</router-link>
        </li>
        <li>
          <router-link :to="{ name: 'list', params: { page: 1 } }">會議列表</router-link>
        </li>
        <li>
          <router-link :to="{ name: 'profileRedirect' }"
                       :class="{'router-link-exact-active': $route.name === 'profile'}">
                          個人報表
          </router-link>
        </li>
        <li>
          <router-link :to="{ name: 'manual' }"
                       :class="{'router-link-exact-active': $route.name === 'manual'}">
            使用手冊</router-link>
        </li>
        <li><a href="#" @click="logout">登出</a></li>
      </ul>
    </div>
  </div>
  <form v-show="false" ref="logoutForm" method="POST" action="https://oauth.cs.nctu.edu.tw/logout"></form>
</div>
</template>

<style lang="scss" scoped>
.logo {
  width: 50px;
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
