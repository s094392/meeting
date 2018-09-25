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
	white-space: nowrap;
}
@media only screen and (max-width: 500px) {
  .o_o {
  	font-size: 20vw;
  }
}
</style>
@endsection

@section('content')
<div class="container">
	<div class="child">
		@if ($expired)
			<h3 class="uk-card-title uk-text-center">因閒置過久而被登出</h3>
		@else
		<h3 class="uk-card-title uk-text-center">又要開會？</h3>
		@endif
		<div class="o_o monospace uk-text-center">\(o_o)/</div>
		<button onclick="login()" id="loginButton" class="uk-button uk-button-primary uk-button-large uk-align-center">
			<span id="loginText">Login</span>
		</button>
	</div>
</div>

<script>
	function login(){
		document.getElementById("loginText").innerText = "Hold...";
		window.location = "{{ $APP_URL }}/cssso/redirect";
	}
</script>
@endsection
