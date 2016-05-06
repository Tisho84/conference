@extends('admin.partials.table')

@section('table')
    <table class="table">
        <thead>
            <tr>
                <th>{{ trans('static.title') }}</th>
                <th>{{ trans('static.category') }}</th>
                @if ($systemAdmin)
                    <th>{{ trans('admin.department') }}</th>
                @endif
                <th>{{ trans('static.uploader') }}</th>
                <th>{{ trans('static.reviewer') }}</th>
                <th>{{ trans('static.created-at') }}</th>
                <th>{{ trans('static.status') }}</th>
                <th>{{ trans('static.action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($papers as $paper)
            <tr>
                <td class="col-md-2">{{ $paper->title }}</td>
                <td class="col-md-2">{{ $categories[$paper->category_id] }}</td>
                @if ($systemAdmin)
                    <td class="col-md-2">{{ $departments[$paper->department_id] }}</td>
                @endif
                <td class="col-md-1">{{ $paper->user->name }}</td>
                @if ($paper->reviewer)
                    <td class="col-md-1">{{ $paper->reviewer->name }}</td>
                @else
                    <td class="col-md-1"></td>
                @endif

                <td class="col-md-1">{{ $paper->created_at }}</td>
                <td class="col-md-1">{{ $statuses[$paper->status_id] }}</td>
                <td class="col-md-2">
                    {!! Form::open(['url' => action('Admin\PaperController@destroy', [$paper->id]), 'method' => 'delete']) !!}
                        <a href="{{ action('Admin\PaperController@show', [$paper->id])}}" class="btn btn-xs btn-warning">{{ trans('static.preview') }}</a>
                        <a href="{{ action('Admin\PaperController@edit', [$paper->id])}}" class="btn btn-xs btn-success">{{ trans('static.edit') }}</a>
                        {!! Form::submit(trans('static.delete'), ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection