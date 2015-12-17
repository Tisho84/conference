@extends('admin.partials.table')

@section('table')
    <table class="table">
        <thead>
        <tr>
            <th>{{ trans('admin.id') }}</th>
            <th>{{ trans('admin.keyword') }}</th>
            <th>{{ trans('admin.image') }}</th>
            <th>{{ trans('admin.active') }}</th>
            <th>{{ trans('admin.sort') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($departments as $department)
            <tr>
                <td>{{ $department->id }}</td>
                <td>{{ $department->keyword }}</td>
                <td>{!! HTML::image(asset('images/' . $department->image), null, ['class' => 'img-responsive']) !!}</td>
                <td>{{ $department->active }}</td>
                <td>{{ $department->sort }}</td>
                <td>
                    {!! Form::open(['url' => action('Admin\CategoryController@destroy', [$department->id]), 'method' => 'delete']) !!}
                        <a href="{{ action('Admin\CategoryController@show', [$department->id]) }}" class="btn btn-xs btn-warning">{{ trans('admin.details') }}</a>
                        <a href="{{ action('Admin\CategoryController@edit', [$department->id]) }}" class="btn btn-xs btn-success">{{ trans('admin.edit') }}</a>
                        {!! Form::submit(trans('admin.delete'), ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection