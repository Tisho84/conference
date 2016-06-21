{{-- //load all meta data --}}
@section('meta')
    @include('layouts.partials.head.meta')
@show
{{-- //define title --}}
<title>@yield('title', trans('static.app-title'))</title>
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" >
{{-- //load css --}}
@section('css')
    {!! HTML::style('/css/app.css') !!}
@show
{{-- //load legacy scripts --}}
@section('legacy')
    @include('layouts.partials.head.ie-support')
@show