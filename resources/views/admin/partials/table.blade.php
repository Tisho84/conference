@extends('admin.master')

@section('content')
    <div class="panel-heading">
        @yield('table-title', $title)
        <a href="{{ $url }}" class="btn btn-primary btn-xs pull-right">{{ trans('admin.add') }}</a>
    </div>

    <div class="panel-body">
        @yield('table')
    </div>
@endsection