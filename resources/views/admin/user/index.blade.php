@extends('admin.partials.table')

@section('table')
    <table class="table table-hover">
        <thead>
        <tr>
            <th>{{ trans('admin.id') }}</th>
            <th>{{ trans('admin.name') }}</th>
            @if ($systemAdmin)
                <th>{{ trans('admin.department') }}</th>
            @endif
            <th>{{ trans('admin.email') }}</th>
            <th>{{ trans('admin.user-type') }}</th>
            <th>{{ trans('admin.institution') }}</th>
            <th>{{ trans('admin.active') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                @if ($systemAdmin)
                    <td>{{ isset($departments[$user->department_id]) ? $departments[$user->department_id] : '' }}</td>
                @endif
                <td>{{ $user->email }}</td>
                <td>{{ isset($types[$user->user_type_id]) ? $types[$user->user_type_id] : trans('static.none') }}</td>
                <td>{{ $user->institution }}</td>
                <td>{{ boolString($user->active) }}</td>
                <td>
                    {!! Form::open(['url' => action('Admin\UsersController@destroy', [$user->id]), 'method' => 'delete']) !!}
                        @if (request()->get('paper_id'))
                            <a href="{{ action('Admin\UsersController@paper', [$user->id, request()->get('paper_id')]) }}" class="btn btn-primary btn-xs">{{ trans('static.select') }}</a>
                        @endif
                        @if (systemAccess(1, $user))
                            <a href="{{ action('Admin\PaperController@index', ['user_id' => $user->id])}}" class="btn btn-xs btn-primary">{{ trans('static.menu-papers') }}</a>
                        @endif
                        @if (systemAccess(2, $user))
                            <a href="{{ action('Admin\PaperController@index', ['reviewer_id' => $user->id])}}" class="btn btn-xs btn-primary">{{ trans('static.reviews') }}</a>
                        @endif
                        <a href="{{ action('Admin\UsersController@edit', [$user->id]) }}" class="btn btn-xs btn-success">{{ trans('admin.edit') }}</a>
                        {!! Form::submit(trans('admin.delete'), ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection