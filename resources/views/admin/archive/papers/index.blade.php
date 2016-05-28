@extends('admin.partials.table')

@section('table')
    <table class="table">
        <thead>
            <tr>
                <th>{{ trans('static.title') }}</th>
                <th>{{ trans('static.category') }}</th>
                <th>{{ trans('static.uploader') }}</th>
                <th>{{ trans('static.reviewer') }}</th>
                <th>{{ trans('static.created-at') }}</th>
                <th>{{ trans('static.status') }}</th>
                <th>{{ trans('static.reviewed_at') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($papers as $paper)
            <tr>
                <td class="col-md-3">{{ $paper->title }}</td>
                <td class="col-md-3">{{ isset($paper->category) ? $paper->category->langs->first()->name : trans('static.none') }}</td>
                <td class="col-md-1">{{ $paper->user->name }}</td>
                <td class="col-md-1">
                    @if ($paper->reviewer)
                        {{ $paper->reviewer->name }}
                    @endif
                </td>
                <td class="col-md-1">{{ $paper->created_at }}</td>
                <td class="col-md-1">{{ $statuses[$paper->status_id] }}</td>
                <td class="col-md-1">{{ $paper->reviewed_at }}</td>
                <td class="col-md-1">
                    <a href="{{ action('Admin\ArchiveController@showPapers', [$archive->id, $paper->id])}}" class="btn btn-xs btn-primary">{{ trans('admin.details') }}</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection