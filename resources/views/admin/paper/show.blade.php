@extends('admin.master')

@section('content')
    <div class="mt padding-5">
        <h3 class="text-center mb20">{{ trans('static.paper') . ': ' . $paper->title  }} {{ trans('static.preview') }}</h3>
        <form class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.uploader')}}:</label>
                <div class="col-sm-10"><label class="control-label">{{ $paper->user->name }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin.department')}}:</label>
                <div class="col-sm-10"><label class="control-label">{{ $departments[$paper->department_id] }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.category')}}:</label>
                <div class="col-sm-10"><label class="control-label">{{ $categories[$paper->category_id] }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.status')}}:</label>
                <div class="col-sm-10"><label class="control-label">{{ $statuses[$paper->status_id] }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.title')}}:</label>
                <div class="col-sm-10"><label class="control-label">{{ $paper->title }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.description')}}:</label>
                <div class="col-sm-10"><label class="text-left margin-top7">{{ $paper->description }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.authors')}}:</label>
                <div class="col-sm-10"><label class="control-label">{{ $paper->authors }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.paper')}}:</label>
                <div class="col-sm-10"><label class="control-label-right">{!! HTML::link(asset('papers/' . $paper->department->keyword . '/' . $paper->source), $paper->source) !!}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.invoice-description')}}:</label>
                <div class="col-sm-10"><label class="text-left margin-top7">{{ $paper->payment_description }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.invoice')}}:</label>
                <div class="col-sm-10"><label class="control-label-right">{!! HTML::link(asset('papers/' . $paper->department->keyword . '/' . $paper->payment_source), $paper->payment_source) !!}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin.created-at')}}:</label>
                <div class="col-sm-10"><label class="control-label">{{ $paper->created_at }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin.updated-at')}}:</label>
                <div class="col-sm-10"><label class="control-label">{{ $paper->updated_at }}</label></div>
            </div>
            @if ($paper->reviewer)
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ trans('static.reviewer')}}:</label>
                    <div class="col-sm-10"><label class="control-label">{{ $paper->reviewer->name }}</label></div>
                </div>
            @endif
            <div class="form-group">
                <div class="text-center">
                    @include('admin.partials.back')
                </div>
            </div>
        </form>
    </div>
@endsection