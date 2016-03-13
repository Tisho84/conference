{{-- //load all meta data --}}
@section('meta')
    @include('layouts.partials.head.meta')
@show
{{-- //define title --}}
<title>@yield('title', trans('static.title'))</title>
<link href="{!!asset('navicon.ico') !!}" rel="shortcut icon" type="image/vnd.microsoft.icon" />
{{-- //load css --}}
@section('css')
    {!! HTML::style('/css/app.css') !!}
@show
{{-- //load legacy scripts --}}
@section('legacy')
    @include('layouts.partials.head.ie-support')
@show