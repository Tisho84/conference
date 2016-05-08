@extends('admin.partials.table')

@section('table')
    <table class="table">
        <thead>
            <tr>
                <th>{{ trans('admin.id') }}</th>
                {!! buildTh() !!}
                <th>{{ trans('admin.sort') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($options as $option)
            <tr>
                <td>{{ $option->id }}</td>
                @foreach (LaravelLocalization::getSupportedLocales() as $short => $locale)
                    <td>{{ $option->dbLangs->get(dbTrans($short))->title }}</td>
                @endforeach
                <td>{{ $option->sort }}</td>
                <td>
                    {!! Form::open(['url' => action('Admin\CriteriaOptionController@destroy', [$criteria->id, $option->id]), 'method' => 'delete']) !!}
                        <a href="{{ action('Admin\CriteriaOptionController@edit', [$criteria->id, $option->id])}}" class="btn btn-xs btn-success">{{ trans('admin.edit') }}</a>
                    {!! Form::submit(trans('admin.delete'), ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection