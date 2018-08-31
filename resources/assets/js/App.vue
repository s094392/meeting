<template>
<div>
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
import LeftNav from "./components/Shared/LeftNav";
import TopNav from "./components/Shared/TopNav";
import { mapState } from "vuex";

export default {
  name: "App",
  components: {
    LeftNav,
    TopNav
  },
  created() {
    this.fetchUser();
  },
  methods: {
    fetchUser: function() {
      axios.get("/api/me").then(response => {
        this.$store.commit("setUser", response.data);
      });
    }
  }
};
</script>
