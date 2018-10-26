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
		<h3 class="uk-card-title uk-text-center">權限不足，此系統僅限系計中助教使用</h3>
		<div class="o_o monospace uk-text-center">\(o_o)/</div>
		<br>
		<form action="{{ $CSSSO_SERVER }}/logout" method="POST">
			<input type="submit" id="loginButton" class="uk-button uk-button-primary uk-button-large uk-align-center" value="使用其他帳號登入">
		</form>
		</button>
	</div>
</div>
@endsection
