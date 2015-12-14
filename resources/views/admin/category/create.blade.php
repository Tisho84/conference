@extends('admin.master')

@section('content')
    {!! Form::open(['method' => 'post', 'url' => action('Admin\CategoryController@store') ]) !!}
        @include('admin.category.form', [''])
    {!! Form::close() !!}
@stop
