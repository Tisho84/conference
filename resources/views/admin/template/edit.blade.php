@extends('admin.master')

@section('content')
    {!! Form::model($template, ['method' => 'put', 'url' => action('Admin\EmailTemplateController@update', [$template->id]) ]) !!}
        @include('admin.template.form', ['title' => 'admin.update-template'])
    {!! Form::close() !!}
@stop
