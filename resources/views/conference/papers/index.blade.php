@extends('layouts.partials.content')

@section('inner-content')
    <div class="panel-heading">
        @if (request()->get('requests'))
            {{ trans('static.papers-for-review') }}
        @elseif (auth()->user()->is_reviewer)
            {{ trans('static.reviewed-papers') }}
        @else
            {{ trans('static.uploaded-papers') }}
        @endif

        @if (systemAccess(1))
            <a href="{{ action('PaperController@create', [$department->keyword]) }}" class="btn btn-theme btn-xs pull-right">{{ trans('static.add-paper') }}</a>
        @endif
        @if (systemAccess(13))
            @if (request()->get('requests'))
                <a href="{{ action('PaperController@index', [$department->keyword])}}" class="btn btn-xs btn-theme pull-right">{{ trans('static.reviewed-papers') }}</a>
            @else
                <a href="{{ action('PaperController@index', [$department->keyword, 'requests' => 1]) }}" class="btn btn-theme btn-xs pull-right">{{ trans('static.all-papers') }}</a>
            @endif
        @endif
    </div>

    <div class="panel-body">
        @if (count($papers))
            <table class="table table-hover">
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
                        <td class="col-md-3">{{ isset($categories[$paper->category_id]) ? $categories[$paper->category_id] : '' }}</td>
                        <td class="col-md-2">{{ $paper->created_at }}</td>
                        <td class="col-md-1">{{ $statuses[$paper->status_id] ? : '' }}</td>
                        <td class="col-md-3">
                            {!! Form::open(['url' => action('PaperController@destroy', [$department->keyword, $paper->id]), 'method' => 'delete']) !!}
                                @if (request()->get('requests'))
                                    <a href="{{ action('PaperController@show', [$department->keyword, $paper->id, 'requests' => 1])}}" class="btn btn-xs btn-theme">{{ trans('static.preview') }}</a>
                                @else
                                    <a href="{{ action('PaperController@show', [$department->keyword, $paper->id])}}" class="btn btn-xs btn-theme">{{ trans('static.preview') }}</a>
                                @endif
                                @if ($paper->isAuthor())
                                    @if ($paper->canInvoice() && !$lock)
                                        <a href="{{ action('PaperController@getInvoice', [$department->keyword, $paper->id])}}" class="btn btn-xs btn-theme">{{ trans('static.invoice') }}</a>
                                    @endif
                                    @if ($paper->canEdit() && !$lock)
                                        <a href="{{ action('PaperController@edit', [$department->keyword, $paper->id])}}" class="btn btn-xs btn-theme">{{ trans('static.edit') }}</a>
                                        {!! Form::submit(trans('static.delete'), ['class' => 'btn btn-theme btn-xs']) !!}
                                    @endif
                                @endif
                                @if ($paper->isReviewer() && $paper->canEvaluate())
                                    <a href="{{ action('PaperController@getEvaluate', [$department->keyword, $paper->id])}}" class="btn btn-xs btn-theme">{{ trans('static.evaluate') }}</a>
                                @endif
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            {{ trans('static.no-papers') }}
        @endif
    </div>
    <div class="centered text-center">
        {!! $papers->render() !!}
    </div>
@endsection