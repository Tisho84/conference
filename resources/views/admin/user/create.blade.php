@extends('admin.master')

@section('content')
    {!! Form::open(['method' => 'post', 'url' => action('Admin\UsersController@store') ]) !!}
        @include('admin.user.form', ['title' => 'admin.add-user'])
    {!! Form::close() !!}
@endsection