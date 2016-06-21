@extends('admin.partials.table')

@section('table')
    <table id="exportTable" class="table table-hover">
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
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($papers as $paper)
            <tr>
                <td class="col-md-2">{{ $paper->title }}</td>
                <td class="col-md-2">{{ isset($categories[$paper->category_id]) ? $categories[$paper->category_id] : '' }}</td>
                @if ($systemAdmin)
                    <td class="col-md-1">{{ isset($departments[$paper->department_id]) ? $departments[$paper->department_id] : '' }}</td>
                @endif
                <td class="col-md-2">{{ $paper->user->name . ' ' . trans('static.and') . ' ' . $paper->authors }}</td>
                @if ($paper->reviewer)
                    <td class="col-md-1">{{ $paper->reviewer->name }}</td>
                @else
                    <td class="col-md-1"></td>
                @endif

                <td class="col-md-1">{{ $paper->created_at }}</td>
                <td class="col-md-1">{{ $statuses[$paper->status_id] }}</td>
                <td class="col-md-2">
                    {!! Form::open(['url' => action('Admin\PaperController@destroy', [$paper->id]), 'method' => 'delete']) !!}
                        <a href="{{ action('Admin\PaperController@show', [$paper->id])}}" class="btn btn-xs btn-warning">{{ trans('admin.details') }}</a>
                        <a href="{{ action('Admin\PaperController@edit', [$paper->id])}}" class="btn btn-xs btn-success">{{ trans('admin.edit') }}</a>
                        @if (($paper->reviewer_id && systemAccess(2)) || ($paper->reviewer_id && systemAccess(10)))
                            <a href="{{ action('Admin\PaperController@getEvaluate', [$paper->id])}}" class="btn btn-xs btn-primary">{{ trans('admin.evaluate') }}</a>
                        @endif
                        @if (count($paper->requests))
                            <a href="{{ action('Admin\UsersController@index', ['paper_id' => $paper->id])}}" class="btn btn-xs btn-primary">{{ trans('static.reviewers') }}</a>
                        @endif

                        @if ($paper->canEdit())
                            {!! Form::submit(trans('admin.delete'), ['class' => 'btn btn-danger btn-xs']) !!}
                        @endif
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @include('admin.partials.export')
@endsection