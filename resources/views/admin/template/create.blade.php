@extends('admin.master')

@section('content')
    {!! Form::open(['method' => 'post', 'url' => action('Admin\EmailTemplateController@store') ]) !!}
        @include('admin.template.form', ['title' => 'admin.add-template'])
    {!! Form::close() !!}
@stop
