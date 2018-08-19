<template>
<div>
	<h2>WWW 新生訓練 - 點名</h2>
	<div class="uk-card uk-card-default uk-card-body uk-card-small">
		<h3>已到成員</h3>
     <button class="uk-button uk-button-default uk-button-small">tzuyu</button>
     <button class="uk-button uk-button-default uk-button-small">ycchang</button>
     <button class="uk-button uk-button-default uk-button-small">yaowen</button>
     <button class="uk-button uk-button-default uk-button-small">yahsieh</button>
     <button class="uk-button uk-button-default uk-button-small">syujy</button>
     <button class="uk-button uk-button-default uk-button-small">youwei1129</button>
     <button class="uk-button uk-button-default uk-button-small">wwchung</button>
     <button class="uk-button uk-button-default uk-button-small">wangth</button>
		<h3>未到成員</h3>
     <button class="uk-button uk-button-default uk-button-small">yahsieh</button>
     <button class="uk-button uk-button-default uk-button-small">syujy</button>
     <button class="uk-button uk-button-default uk-button-small">youwei1129</button>
    <h3>請假成員</h3>
     <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wwchung</button>
     <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wangth</button>
    <br>
    <router-link :to="{name:'detail'}" class="uk-button uk-button-default uk-button-primary uk-margin-large" >會議開始</router-link>
	</div>
</div>
</template>
<style lang="scss" scoped>
.disabled-normal-color {
  color: #333 !important;
}
</style>


<script>
export default {};
</script>
