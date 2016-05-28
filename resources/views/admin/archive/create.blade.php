@extends('admin.master')

@section('content')
    {!! Form::open(['method' => 'post', 'url' => action('Admin\ArchiveController@store') ]) !!}
        <div class="panel-body">
            @include('layouts.partials.messages.errors')
            <div class="mt text-center">
                <label>{{ trans('static.add-archive-papers') }}</label>
            </div>
            @if ($systemAdmin)
                <div class="form-group">
                    <label for="department_id">{{ trans('admin.department') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                    {!! Form::select('department_id', $departments, null, ['class' => 'form-control']) !!}
                </div>
            @endif
            <div class="form-group">
                <label for="name">{{ trans('static.name') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('static.name')]) !!}
            </div>
            @include('layouts.partials.button', ['button' => trans('static.save') ])
        </div>
    {!! Form::close() !!}
@stop
