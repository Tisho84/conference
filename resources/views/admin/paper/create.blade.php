@extends('admin.master')

@section('content')
    {!! Form::open(['method' => 'post', 'url' => action('Admin\PaperController@store'), 'files' => true ]) !!}
    @include('admin.paper.form', ['title' => 'static.add-paper'])
    {!! Form::close() !!}
@stop
