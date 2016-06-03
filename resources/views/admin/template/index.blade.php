@extends('admin.partials.table')

@section('table')
    <table class="table">
        <thead>
            <tr>
                <th>{{ trans('admin.id') }}</th>
                <th>{{ trans('admin.name') }}</th>
                <th>{{ trans('static.subject') }}</th>
                @if ($systemAdmin)
                    <th>{{ trans('admin.department') }}</th>
                @endif
                <th>{{ trans('static.system-template') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($templates as $template)
            <tr>
                <td>{{ $template->id }}</td>
                <td>{{ $template->name }}</td>
                <td>{{ $template->subject }}</td>
                @if ($systemAdmin)
                    <td>{{ isset($template->department) ? $template->department->langs->first()->name : '' }}</td>
                @endif
                <td>{{ boolString($template->system) }}</td>
                <td class="col-lg-2">
                    {!! Form::open(['url' => action('Admin\EmailTemplateController@destroy', [$template->id]), 'method' => 'delete']) !!}
                        <a href="{{ action('Admin\EmailTemplateController@edit', [$template->id])}}" class="btn btn-xs btn-success">{{ trans('admin.edit') }}</a>
                        {!! Form::submit(trans('admin.delete'), ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection