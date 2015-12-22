@extends('admin.master')

@section('content')
    {!! Form::model($department, ['method' => 'put', 'url' => action('Admin\DepartmentController@update', [$department->id]) ]) !!}
        @include('admin.department.form', ['title' => 'admin.update-category'])
    {!! Form::close() !!}
@stop
