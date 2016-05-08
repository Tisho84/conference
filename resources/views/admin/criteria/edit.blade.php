@extends('admin.master')

@section('content')
    {!! Form::model($criteria, ['method' => 'put', 'url' => action('Admin\CriteriaController@update', [$criteria->id]) ]) !!}
        @include('admin.criteria.form', ['title' => 'admin.update-criteria'])
    {!! Form::close() !!}
@stop
