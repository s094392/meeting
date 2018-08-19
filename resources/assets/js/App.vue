<template>
<div>
	<TopNav />
	<div class="uk-padding">
		<div uk-grid>
			<div class="uk-width-1-5@m"><LeftNav/></div>
			<div class="uk-width-3-5@m">
				<router-view name="main"></router-view>
			</div>
			<div class="uk-width-1-5@m">
				<router-view name="right"></router-view>
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
import LeftNav from "./components/LeftNav";
import TopNav from "./components/TopNav";

export default {
  name: "App",
  components: {
    LeftNav,
    TopNav
  }
};
</script>
