@extends('admin.master')

@section('content')
    {!! Form::model($paper, ['method' => 'put', 'url' => action('Admin\PaperController@update', [$paper->id]), 'files' => true]) !!}
        {!! Form::hidden('id', $paper->id) !!}
        @include('admin.paper.form', ['title' => 'static.updating-paper'])
    {!! Form::close() !!}
@stop
