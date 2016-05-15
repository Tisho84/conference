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
                <th>{{ trans('admin.active') }}</th>
                <th>{{ trans('admin.sort') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                @foreach (LaravelLocalization::getSupportedLocales() as $short => $locale)
                    <td>{{ $category->dbLangs->get(dbTrans($short))->name }}</td>
                @endforeach
                @if ($systemAdmin)
                    <td>{{ $departments[$category->department_id] }}</td>
                @endif
                <td>{{ boolString($category->active) }}</td>
                <td>{{ $category->sort }}</td>
                <td>
                    {!! Form::open(['url' => action('Admin\CategoryController@destroy', [$category->id]), 'method' => 'delete']) !!}
                        <a href="{{ action('Admin\CategoryController@edit', [$category->id])}}" class="btn btn-xs btn-success">{{ trans('admin.edit') }}</a>
                        {!! Form::submit(trans('admin.delete'), ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection