@extends('admin.master')

@section('content')
    {!! Form::open(['method' => 'post', 'url' => action('Admin\CriteriaOptionController@store', [$criteria->id]) ]) !!}
        @include('admin.criteria.option.form', ['title' => 'admin.add-option'])
    {!! Form::close() !!}
@stop
