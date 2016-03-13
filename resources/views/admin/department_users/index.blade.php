@extends('admin.partials.table')

@section('table')
    <table class="table">
        <thead>
        <tr>
            <th>{{ trans('admin.id') }}</th>
            <th>{{ trans('admin.name') }}</th>
            <th>{{ trans('admin.email') }}</th>
            <th>{{ trans('admin.email2') }}</th>
            <th>{{ trans('admin.user-type') }}</th>
            <th>{{ trans('admin.institution') }}</th>
            <th>{{ trans('admin.active') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($department->users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->email2 }}</td>
                {{-- TODO --}}
                <td>{{ $user->userType }}</td>
                <td>{{ $user->institution }}</td>
                <td>{{ $user->active }}</td>
                <td>
                    {!! Form::open(['url' => action('Admin\DepartmentUsersController@destroy', [$department->id, $user->id]), 'method' => 'delete']) !!}
                        <a href="{{ action('Admin\DepartmentUsersController@show', [$department->id], $user->id) }}" class="btn btn-xs btn-warning">{{ trans('admin.details') }}</a>
                        <a href="{{ action('Admin\DepartmentUsersController@edit', [$department->id, $user->id]) }}" class="btn btn-xs btn-success">{{ trans('admin.edit') }}</a>
                        {!! Form::submit(trans('admin.delete'), ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection