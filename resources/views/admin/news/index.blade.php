@extends('admin.partials.table')

@section('table')
    <table class="table table-hover">
        <thead>
            <tr>
                <th>{{ trans('admin.id') }}</th>
                {!! buildTh() !!}
                @if ($systemAdmin)
                    <th>{{ trans('admin.department') }}</th>
                @endif
                <th>{{ trans('static.created-at') }}</th>
                <th>{{ trans('static.updated_at') }}</th>
                <th>{{ trans('admin.active') }}</th>
                <th>{{ trans('static.sort') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($news as $value)
            <tr>
                <td>{{ $value->id }}</td>
                @foreach (LaravelLocalization::getSupportedLocales() as $short => $locale)
                    <td>{{ $value->dbLangs->get(dbTrans($short))->title }}</td>
                @endforeach
                @if ($systemAdmin)
                    <td>{{ $departments[$value->department_id] }}</td>
                @endif
                <td>{{ $value->created_at }}</td>
                <td>{{ $value->updated_at }}</td>
                <td>{{ boolString($value->active) }}</td>
                <td>{{ $value->sort }}</td>
                <td>
                    {!! Form::open(['url' => action('Admin\NewsController@destroy', [$value->id]), 'method' => 'delete']) !!}
                        <a href="{{ action('Admin\NewsController@edit', [$value->id])}}" class="btn btn-xs btn-success">{{ trans('admin.edit') }}</a>
                        {!! Form::submit(trans('admin.delete'), ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection