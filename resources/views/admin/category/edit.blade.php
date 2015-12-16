@extends('admin.master')

@section('content')
    {!! Form::model($category, ['method' => 'put', 'url' => action('Admin\CategoryController@update', [$category->id]) ]) !!}
        @include('admin.category.form', ['title' => 'admin.update-category'])
    {!! Form::close() !!}
@stop
