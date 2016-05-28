@extends('admin.partials.table')

@section('table')
    <table class="table">
        <thead>
            <tr>
                <th>{{ trans('admin.id') }}</th>
                @if ($systemAdmin)
                    <th>{{ trans('admin.department') }}</th>
                @endif
                <th>{{ trans('static.name') }}</th>
                <th>{{ trans('static.created-at') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($archives as $archive)
            <tr>
                <td>{{ $archive->id }}</td>
                @if ($systemAdmin)
                    <td>{{ isset($archive->department) ? $archive->department->langs->first()->name : trans('static.none') }}</td>
                @endif
                <td>{{ $archive->name }}</td>
                <td>{{ $archive->created_at }}</td>
                <td>
                    <a href="{{ action('Admin\ArchiveController@show', [$archive->id])}}" class="btn btn-xs btn-primary">{{ trans('admin.details') }}</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection