<template>
<div>
	<div class="buttons uk-display-inline-block">
		<router-link :to="{name: 'checkin', params: {id: id}}"  class="uk-button uk-button-default uk-button-primary">開始</router-link>
			<button class="uk-button uk-button-default" type="button">請假</button>
			<div uk-dropdown="mode: click;">
				<ul class="uk-nav uk-dropdown-nav">
					<li class="uk-nav-header">請假原因</li>
					<li><a href="#">值班</a></li>
					<li><a href="#">實習</a></li>
					<li><a href="#">回家</a></li>
					<li><a href="#">大考</a></li>
					<li class="uk-nav-divider"></li>
					<li><a href="#">其他</a></li>
				</ul>
			</div>
		<button class="uk-button uk-button-default">編輯</button>
		<button v-on:click="$emit('delete')" class="uk-button uk-button-default">刪除</button>
	</div>
</div>
</template>

<style lang="scss">
.buttons {
  white-space: nowrap;
  width: 100%;
  overflow: auto;
}
</style>

<script>
export default {
  props: ["id"]
};
</script>
