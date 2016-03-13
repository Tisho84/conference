@extends('admin.master')

@section('content')
    {!! Form::model($type, ['method' => 'put', 'url' => action('Admin\UserTypesController@update', [$type->id]) ]) !!}
        @include('admin.user_type.form', ['title' => 'admin.update-user-type'])
    {!! Form::close() !!}
@endsection