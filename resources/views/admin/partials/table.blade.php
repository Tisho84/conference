@extends('admin.master')

@section('content')
    <div class="panel-heading">
        @yield('table-title', $title)
        @if(isset($export) && $export)
            <button id="exportButton" class="btn btn-xs btn-danger clearfix pull-right"><span class="fa fa-file-pdf-o"></span>{{ trans('static.export') }}</button>
        @endif
        @if(isset($url) && $url)
            <a href="{{ $url }}" class="btn btn-primary btn-xs pull-right">{{ trans('admin.add') }}</a>
        @endif
        @if(isset($counter))
            <a href="#" class="btn btn-default btn-xs pull-right disabled">
                {{ trans('static.count') . ': '}}
                <b>{{ $counter }}</b>
            </a>
        @endif
    </div>
    <div class="panel-body">
        @yield('table')
    </div>
@endsection