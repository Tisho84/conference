@extends('admin.master')

@section('content')
    {!! Form::model($department, ['method' => 'put', 'files' => true, 'url' => action('Admin\DepartmentController@update', [$department->id]) ]) !!}
        @include('admin.department.form', ['title' => 'admin.update-category'])
        {!! Form::hidden('id', $department->id) !!}
    {!! Form::close() !!}
@stop
