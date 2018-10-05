@extends('base')

@section('content')
<div id="app">
    <app></app>
</div>
<script src="{{ asset('js/manifest.js') }}"></script>
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endsection
