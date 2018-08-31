@extends('base')

@section('style')
<style>
.container {
  position: relative;
  height: 100vh;
  width: 100vw;
}
.child {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.o_o {
  font-size: 110px;
}
@media only screen and (max-width: 400px) {
  .o_o {
  	font-size: 25vw;
  }
}
</style>
@endsection

@section('content')
<div class="container">
	<div class="child">
		<h3 class="uk-card-title uk-text-center">又要開會？</h3>
		<div class="o_o uk-text-center">\(o_o)/</div>
		<button onclick="login()" id="loginButton" class="uk-button uk-button-primary uk-button-large uk-align-center">
			<span id="loginText">Login</span>
		</button>
	</div>
</div>

<script>
	function login(){
		document.getElementById("loginText").innerText = "Hold...";
		window.location = "/cssso/redirect";
	}
</script>
@endsection
