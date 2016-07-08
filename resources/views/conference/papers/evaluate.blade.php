@extends('layouts.partials.content')

@section('inner-content')
    <div class="panel-heading">{{ trans('static.evaluating-paper') }}</div>
    <div class="panel-body">
        @include('layouts.partials.messages.errors')
        {!! Form::open(['method' => 'POST', 'url' => action('PaperController@postEvaluate', [$department->keyword, $paper->id]), 'class' => 'form-horizontal']) !!}
            <div class="centered text-center">
                <h3>{{ trans('static.evaluate-criteria') }}</h3>
            </div>
            <div class="clearfix"></div>
            @foreach ($criteria as $v)
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="id{{ $v->id }}">
                        {!! $v->langs->first()->title !!}
                        @if($v->required)
                            <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
                        @endif
                    </label>
                    <div class="col-sm-9">{!! $v->build() !!}</div>
                </div>
            @endforeach
            <div class="form-group">
                <div class="text-center">
                    <a href="{{ action('PaperController@index', [$department->keyword]) }}" class="btn btn-theme">{{ trans('static.menu-back') }}</a>
                    @if (count($criteria))
                        <button type="submit" class="btn btn-theme">{{ trans('static.save') }}</button>
                    @endif
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection