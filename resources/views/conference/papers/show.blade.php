@extends('layouts.partials.content')

@section('inner-content')
    <div class="panel-heading">{{ trans('static.preview-paper') }}</div>
    <div class="panel-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label">{{ trans('static.category')}}:</label>
                <div class="col-sm-9"><label class="control-label-right">{{ $categories[$paper->category_id] }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{ trans('static.title')}}:</label>
                <div class="col-sm-9"><label class="control-label-right">{{ $paper->title }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{ trans('static.description')}}:</label>
                <div class="col-sm-9"><label class="control-label-right">{{ $paper->description }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{ trans('static.authors')}}:</label>
                <div class="col-sm-9"><label class="control-label-right">{{ $paper->authors }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{ trans('static.status')}}:</label>
                <div class="col-sm-9"><label class="control-label-right">{{ $statuses[$paper->status_id] }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{ trans('static.created-at')}}:</label>
                <div class="col-sm-9"><label class="control-label-right">{{ $paper->created_at }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{ trans('static.updated_at')}}:</label>
                <div class="col-sm-9"><label class="control-label-right">{{ $paper->updated_at }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{ trans('static.download')}}:</label>
                <div class="col-sm-9"><label class="control-label-right">{!! HTML::link(urlencode('papers/' . $department->keyword . '/' . $paper->source), $paper->source) !!}</label></div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    @include('layouts.partials.back')
                </div>
            </div>

        </form>
    </div>
@endsection