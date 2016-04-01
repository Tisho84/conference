@extends('layouts.partials.content')

@section('inner-content')
    <div class="panel-heading">
        @if (auth()->user()->is_reviewer)
            {{ trans('static.reviewed-papers') }}
        @else
            {{ trans('static.uploaded-papers') }}
        @endif
        <a href="{{ action('PaperController@create', [$department->keyword]) }}" class="btn btn-primary btn-xs pull-right">{{ trans('static.add-paper') }}</a>
    </div>

    <div class="panel-body">
        <table class="table">
            <thead>
            <tr>
                <th>{{ trans('static.title') }}</th>
                <th>{{ trans('static.category') }}</th>
                <th>{{ trans('static.created-at') }}</th>
                <th>{{ trans('static.status') }}</th>
                <th>{{ trans('static.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($papers as $paper)
                <tr>
                    <td class="col-md-3">{{ $paper->title }}</td>
                    <td class="col-md-3">{{ $categories[$paper->category_id] }}</td>
                    <td class="col-md-2">{{ $paper->created_at }}</td>
                    <td class="col-md-1">{{ $statuses[$paper->status_id] }}</td>
                    <td class="col-md-3">
                        {!! Form::open(['url' => action('PaperController@destroy', [$department->keyword, $paper->id]), 'method' => 'delete']) !!}
                            <a href="{{ action('PaperController@show', [$department->keyword, $paper->id])}}" class="btn btn-xs btn-primary">{{ trans('static.preview') }}</a>
                            @if ($paper->canInvoice())
                                <a href="{{ action('PaperController@getInvoice', [$department->keyword, $paper->id])}}" class="btn btn-xs btn-primary">{{ trans('static.invoice') }}</a>
                            @endif
                            @if ($paper->canEdit())
                                <a href="{{ action('PaperController@edit', [$department->keyword, $paper->id])}}" class="btn btn-xs btn-primary">{{ trans('static.edit') }}</a>
                                {!! Form::submit(trans('static.delete'), ['class' => 'btn btn-primary btn-xs']) !!}
                            @endif
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection