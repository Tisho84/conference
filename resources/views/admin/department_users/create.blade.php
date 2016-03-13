@extends('admin.master')

@section('content')
    {!! Form::open(['method' => 'post', 'url' => action('Admin\DepartmentUsersController@store', [$department->id]) ]) !!}
        @include('admin.department_users.form', ['title' => 'admin.add-user'])
    {!! Form::close() !!}
@endsection