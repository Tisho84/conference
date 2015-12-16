@extends('admin.master')

@section('content')
    {!! Form::open(['method' => 'post', 'url' => action('Admin\CategoryController@store') ]) !!}
        @include('admin.category.form', ['title' => 'admin.add-category'])
    {!! Form::close() !!}
@stop
