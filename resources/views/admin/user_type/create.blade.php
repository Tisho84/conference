@extends('admin.master')

@section('content')
    {!! Form::open(['method' => 'post', 'url' => action('Admin\UserTypesController@store') ]) !!}
        @include('admin.user_type.form', ['title' => 'admin.add-user-type'])
    {!! Form::close() !!}
@endsection