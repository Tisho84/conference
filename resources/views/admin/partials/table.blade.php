@extends('admin.master')

@section('content')
    <div class="panel-heading">
        @yield('table-title', $title)
        @if(isset($url) && $url)
            <a href="{{ $url }}" class="btn btn-primary btn-xs pull-right">{{ trans('admin.add') }}</a>
        @endif
    </div>

    <div class="panel-body">
        @yield('table')
    </div>
@endsection