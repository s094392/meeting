<template>
<div uk-grid>
  <div class="uk-width-3-4@m">
    <h2>WWW 新生訓練 - 點名</h2>
    <div class="uk-card uk-card-default uk-card-body uk-card-small">
      <h3>已到成員</h3>
      <button class="uk-button uk-button-default uk-button-small uk-margin-small-right"
               v-for="(member, idx) in presentMembers" :key="member.id" @click="toNotPresent(idx)" v-if="member">
        {{member}}
      </button>
      <h3>未到成員</h3>
      <button class="uk-button uk-button-default uk-button-small uk-margin-small-right"
              v-for="(member, idx) in notPresentMembers" :key="member.id" @click="toPresent(idx)" v-if="member">
        {{member}}
      </button>
      <h3>請假成員</h3>
      <button class="uk-button uk-button-default uk-button-small uk-margin-small-right disabled-normal-color"
              v-for="member in onLeaveMembers" :key="member.id" v-if="member" disabled>
        {{member}}
      </button>
      <br>
      <router-link :to="{name:'detail', params: {id: 1, view: 'data'}}" class="uk-button uk-button-default uk-button-primary uk-margin-large" >會議開始</router-link>
    </div>
  </div>
</div>
</template>
<style lang="scss" scoped>
.disabled-normal-color {
  color: #333 !important;
}
</style>


<script>
export default {
  data: function() {
    return {
      presentMembers: [],
      notPresentMembers: [
        "wangtr",
        "apple",
        "weicc",
        "hwlin1414",
        "hyili",
        "tzuyu"
      ],
      onLeaveMembers: ["youwei1129", "wwchung"]
    };
  },
  methods: {
    toNotPresent: function(idx) {
      this.notPresentMembers.push(this.presentMembers[idx]);
      this.$set(this.presentMembers, idx, null);
    },
    toPresent: function(idx) {
      this.presentMembers.push(this.notPresentMembers[idx]);
      this.$set(this.notPresentMembers, idx, null);
    }
  }
};
</script>
