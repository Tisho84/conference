@extends('layouts.partials.content')

@section('inner-content')
    <div class="panel-heading">{{ trans('static.adding-paper') }}</div>
    <div class="panel-body">
        @include('layouts.partials.messages.errors')
        {!! Form::open(['method' => 'post', 'url' => action('PaperController@store', [$department->keyword]), 'files' => true]) !!}
            @include('conference.papers.form')
        {!! Form::close() !!}
    </div>
@endsection