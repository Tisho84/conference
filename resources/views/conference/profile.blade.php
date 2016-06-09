@extends('layouts.partials.content')

@section('inner-content')
    <div class="panel-heading">{{ trans('static.profile-information') }}</div>
    {!! Form::model(auth()->user(), ['url' => route('department::user::profile', [$department->keyword]), 'method' => 'put']) !!}
        <div class="panel-body">
            @include('layouts.partials.messages.errors')
            @include('auth.personal_form')
            @if (!isset($disabled) || (isset($disabled) && !$disabled))
                @include('layouts.partials.button', ['button' => trans('static.save') ])
            @endif
        </div>
    {!! Form::close() !!}
@endsection