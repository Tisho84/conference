@extends('admin.master')

@section('content')
    {!! Form::model($option, ['method' => 'put', 'url' => action('Admin\CriteriaOptionController@update', [$criteria->id, $option->id]) ]) !!}
        @include('admin.criteria.option.form', ['title' => 'admin.update-option'])
    {!! Form::close() !!}
@stop
