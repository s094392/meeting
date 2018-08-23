<template>
<div class="uk-margin-left uk-visible@m" uk-sticky="offset: 40;">
	<div>
		<div class="uk-margin-bottom">
			<img src="/img/meeting.png" class="logo uk-margin-small-right">
			<span class="uk-text-large uk-text-bold">Meeting</span>
		</div>
		<ul class="uk-nav uk-nav-default uk-nav-primary">
			<li><span class="uk-text-large uk-text-lead uk-text-capitalize">tsengcy</span> 你好</li>
			<li class="uk-nav-divider"></li>
			<li>
				<router-link :to="{ name: '/'}">首頁</router-link>
			</li>
			<li>
				<router-link :to="{ name: 'list'}">會議列表</router-link>
			</li>
			<li><a href="#">個人報表</a></li>
			<li><a href="#">登出</a></li>
		</ul>
	</div>
</div>
</template>

<style lang="scss" scoped>
.logo {
  width: 50px;
}
</style>


<script>
export default {};
</script>
