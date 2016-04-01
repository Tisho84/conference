@extends('layouts.partials.content')

@section('inner-content')
    <div class="panel-heading">{{ trans('static.updating-paper') }}</div>
    <div class="panel-body">
        @include('layouts.partials.messages.errors')
        {!! Form::model($paper, ['method' => 'put', 'url' => action('PaperController@update', [$department->keyword, $paper->id]), 'files' => true]) !!}
            @include('conference.papers.form')
            {!! Form::hidden('id', $paper->id) !!}
        {!! Form::close() !!}
    </div>
@endsection