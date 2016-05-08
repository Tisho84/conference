@extends('admin.master')

@section('content')
    {!! Form::open(['method' => 'post', 'url' => action('Admin\CriteriaController@store') ]) !!}
        @include('admin.criteria.form', ['title' => 'admin.add-criteria'])
    {!! Form::close() !!}
@stop
