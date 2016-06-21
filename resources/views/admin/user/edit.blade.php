@extends('admin.master')

@section('content')
    {!! Form::model($user, ['method' => 'put', 'url' => action('Admin\UsersController@update', [$user->id]), 'autocomplete' => "off"]) !!}
        {!! Form::hidden('user_id', $user->id) !!}
        @include('admin.user.form', ['title' => 'admin.update-user'])
    {!! Form::close() !!}
@endsection