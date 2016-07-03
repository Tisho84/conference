@extends('admin.master')

@section('content')
    <div class="mt padding-5">
        <h3 class="text-center mb20">{{ trans('static.paper') . ': ' . $paper->title  }} {{ trans('static.preview') }}</h3>
        <form class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.uploader')}}:</label>
                <div class="col-sm-10"><label class="control-label-right">{{ $paper->user->name }}</label></div>
            </div>
            @if($systemAdmin)
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ trans('admin.department')}}:</label>
                    <div class="col-sm-10"><label class="control-label-right">{{ $departments[$paper->department_id] }}</label></div>
                </div>
            @endif
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.category')}}:</label>
                <div class="col-sm-10"><label class="control-label-right">{{ $categories[$paper->category_id] }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.status')}}:</label>
                <div class="col-sm-10"><label class="control-label-right">{{ $statuses[$paper->status_id] }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.title')}}:</label>
                <div class="col-sm-10"><label class="control-label-right">{{ $paper->title }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.description')}}:</label>
                <div class="col-sm-10"><label class="text-left control-label-right">{{ $paper->description }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.authors')}}:</label>
                <div class="col-sm-10"><label class="control-label-right">{{ $paper->authors }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('static.paper')}}:</label>
                <div class="col-sm-10"><label class="control-label-right">{!! HTML::link('papers/' . $paper->department->keyword . '/' . rawurlencode($paper->source), $paper->source) !!}</label></div>
            </div>
            @if ($paper->payment_description)
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ trans('static.invoice-description')}}:</label>
                    <div class="col-sm-10"><label class="text-left control-label-right">{{ $paper->payment_description }}</label></div>
                </div>
            @endif
            @if ($paper->payment_source)
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ trans('static.invoice')}}:</label>
                    <div class="col-sm-10"><label class="control-label-right">{!! HTML::link('papers/' . $paper->department->keyword . '/' . rawurlencode($paper->payment_source), $paper->payment_source) !!}</label></div>
                </div>
            @endif
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin.created-at')}}:</label>
                <div class="col-sm-10"><label class="control-label-right">{{ $paper->created_at }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin.updated-at')}}:</label>
                <div class="col-sm-10"><label class="control-label-right">{{ $paper->updated_at }}</label></div>
            </div>
            @if ($paper->reviewer)
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ trans('static.reviewer')}}:</label>
                    <div class="col-sm-10"><label class="control-label-right">{{ $paper->reviewer->name }}</label></div>
                </div>
            @endif
            @if ($paper->reviewed_at)
                <div class="centered text-center">
                    <h3>{{ trans('static.evaluate-info') }}</h3>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ trans('static.reviewed_at')}}:</label>
                    <div class="col-sm-10"><label class="control-label-right">{{ $paper->reviewed_at }}</label></div>
                </div>
                @foreach ($paper->criteria as $criteria)
                    <div class="form-group">
                        <label class="col-sm-2 control-label">{{ $criteria->langs->first()->title }}:</label>
                        <div class="col-sm-10">
                            <label class="control-label-right">
                                @if (count($criteria->options) > 0)
                                    @foreach ($criteria->options as $option)
                                        @if ($criteria->pivot->value == $option->id)
                                            {{ $option->langs->first()->title }}
                                        @endif
                                    @endforeach
                                @else
                                    {{ $criteria->pivot->value }}
                                @endif
                            </label>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="form-group">
                <div class="text-center">
                    @include('admin.partials.back')
                </div>
            </div>
        </form>
    </div>
@endsection