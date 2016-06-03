@extends('admin.master')

@section('content')
    {!! Form::open(['method' => 'POST', 'url' => action('Admin\PaperController@postEvaluate', [$paper->id])]) !!}
        <div class="panel-body">
            @include('layouts.partials.messages.errors')
            <div class="centered text-center">
                <h3>{{ trans('static.evaluate-criteria') }}</h3>
            </div>
            <div class="clearfix"></div>
            @foreach ($criteria as $v)
                <div class="form-group">
                    <label for="id{{ $v->id }}">
                        {!! $v->langs->first()->title !!}
                        @if($v->required)
                            <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
                        @endif
                    </label>
                    {!! $v->build() !!}
                </div>
            @endforeach
            <div class="form-group">
                <label for="email">{{ trans('static.send-email') }}</label>
                {!! Form::checkbox('email', null, null, ['id' => 'email']) !!}
            </div>
            @include('layouts.partials.button', ['button' => trans('static.save') ])
        </div>
    {!! Form::close() !!}
@endsection