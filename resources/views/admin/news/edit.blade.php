@extends('admin.master')

@section('content')
    {!! Form::model($news, ['method' => 'put', 'url' => action('Admin\NewsController@update', [$news->id]) ]) !!}
        @include('admin.news.form', ['title' => 'static.update-news'])
    {!! Form::close() !!}
@stop
