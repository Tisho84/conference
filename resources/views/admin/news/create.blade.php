@extends('admin.master')

@section('content')
    {!! Form::open(['method' => 'post', 'url' => action('Admin\NewsController@store') ]) !!}
        @include('admin.news.form', ['title' => 'static.add-news'])
    {!! Form::close() !!}
@stop
