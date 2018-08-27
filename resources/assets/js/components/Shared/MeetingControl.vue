<template>
<div>
	<div class="buttons uk-display-inline-block">
		<div v-if="status==this.$meetingStatus.Initialize" >
			<router-link :to="{name: 'checkin', params: {id: id}}"  
				class="uk-button uk-button-default uk-button-primary">開始</router-link>
			<router-link :to="{name: 'edit', params: {id: id}}"   class="uk-button uk-button-default">編輯</router-link>
			<button v-on:click="$emit('delete')" class="uk-button uk-button-default">取消</button>
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
			<button class="uk-button uk-button-default" type="button">遲到報備</button>
			<button class="uk-button uk-button-default" type="button">早退報備</button>
		</div>
		<div v-if="status=='Started'" >
			<button class="uk-button uk-button-default uk-button-primary" type="button">結束</button>
		</div>
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
  props: ["id", "status"]
};
</script>
