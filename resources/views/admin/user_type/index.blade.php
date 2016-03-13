@extends('admin.partials.table')

@section('table')
    <table class="table">
        <thead>
        <tr>
            <th>{{ trans('admin.id') }}</th>
            <th>{{ trans('admin.name') }}</th>
            <th>{{ trans('admin.access') }}</th>
            <th>{{ trans('admin.active') }}</th>
            <th>{{ trans('admin.sort') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($userTypes as $type)
            <tr>
                <td>{{ $type->id }}</td>
                <td>{{ $type->title }}</td>
                <td>{{ $access[$type->id] }}</td>
                <td>{{ $type->active }}</td>
                <td>{{ $type->sort }}</td>
                <td>
                    {!! Form::open(['url' => action('Admin\UserTypesController@destroy', [$type->id]), 'method' => 'delete']) !!}
                        <a href="{{ action('Admin\UserTypesController@edit', [$type->id])}}" class="btn btn-xs btn-success">{{ trans('admin.edit') }}</a>
                        {!! Form::submit(trans('admin.delete'), ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection