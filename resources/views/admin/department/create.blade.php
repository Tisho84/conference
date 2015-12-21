@extends('admin.master')

@section('content')
    {!! Form::open(['method' => 'post', 'url' => action('Admin\DepartmentController@store'), 'files' => true]) !!}
        @include('admin.department.form', ['title' => 'admin.add-category'])
    {!! Form::close() !!}
@endsection