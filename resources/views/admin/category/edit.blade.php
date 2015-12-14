@extends('admin.master')

@section('content')
    {!! Form::model($category, ['method' => 'post', 'url' => action('Admin\CategoryController@edit') ]) !!}
        @include('admin.category.form')
    {!! Form::close() !!}
@stop
