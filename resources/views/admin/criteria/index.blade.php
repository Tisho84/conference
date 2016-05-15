@extends('admin.partials.table')

@section('table')
    <table class="table">
        <thead>
            <tr>
                <th>{{ trans('admin.id') }}</th>
                {!! buildTh() !!}
                @if ($systemAdmin)
                    <th>{{ trans('admin.department') }}</th>
                @endif
                <th>{{ trans('static.field-type') }}</th>
                <th>{{ trans('static.is-required') }}</th>
                <th>{{ trans('static.is-visible') }}</th>
                <th>{{ trans('static.admin-criteria') }}</th>
                <th>{{ trans('static.sort') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($criteria as $value)
            <tr>
                <td>{{ $value->id }}</td>
                @foreach (LaravelLocalization::getSupportedLocales() as $short => $locale)
                    <td>{{ $value->dbLangs->get(dbTrans($short))->title }}</td>
                @endforeach
                @if ($systemAdmin)
                    <td>{{ $departments[$value->department_id] }}</td>
                @endif
                <td>{{ $types[$value->type_id] }}</td>
                <td>{{ boolString($value->required) }}</td>
                <td>{{ boolString($value->visible) }}</td>
                <td>{{ boolString($value->admin) }}</td>
                <td>{{ $value->sort }}</td>
                <td>
                    {!! Form::open(['url' => action('Admin\CriteriaController@destroy', [$value->id]), 'method' => 'delete']) !!}
                        <a href="{{ action('Admin\CriteriaController@edit', [$value->id])}}" class="btn btn-xs btn-success">{{ trans('admin.edit') }}</a>
                        @if ($value->type['option'])
                            <a href="{{ action('Admin\CriteriaOptionController@index', [$value->id])}}" class="btn btn-xs btn-primary">{{ trans('static.options') }}</a>
                        @endif
                    {!! Form::submit(trans('admin.delete'), ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection