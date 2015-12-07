{{-- //load all meta data --}}
@section('meta')
    @include('layouts.partials.head.meta')
@show
{{-- //define title --}}
<title>@yield('title', trans('static.title'))</title>
{{-- //load css --}}
@section('css')
    {!! HTML::style('/css/app.css') !!}
    {{--<!-- Custom CSS -->--}}
    {{--{!! HTML::style('/css/sb-admin/sb-admin.css') !!}--}}
    {{--<!-- Custom Fonts -->--}}
    {{--{!! HTML::style('/css/sb-admin/font-awesome.min.css') !!}--}}
@show
{{-- //load legacy scripts --}}
@section('legacy')
    @include('layouts.partials.head.ie-support')
@show