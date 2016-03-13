@extends('admin.master')

@section('content')
    {!! Form::model($user, ['method' => 'put', 'url' => action('Admin\DepartmentUsersController@update', [$department->id, $user->id]) ]) !!}
        @include('admin.department_users.form', ['title' => 'admin.update-user'])
    {!! Form::close() !!}
@endsection