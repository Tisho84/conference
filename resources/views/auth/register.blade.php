@extends('layouts.partials.content')

@section('inner-content')
    <div class="panel-heading">{{ trans('static.menu-register') }}</div>
    {!! Form::open(['method' => 'post', 'url' => route('department::auth::register', [$department->keyword, 'reviewer' => request('reviewer')])]) !!}
        <div class="panel-body">
            @include('layouts.partials.messages.errors')
            <div class="mt text-center">
                <label>{{ trans('static.personal-information') }}</label>
            </div>
            @include('auth.personal_form')
        </div>
        <hr>
        <div class="mt text-center">
            <label>{{ trans('static.profile-information') }}</label>
        </div>
        <div class="panel-body">
            @include('auth.profile_form')
            @include('layouts.partials.button', ['button' => trans('static.save') ])
        </div>
    {!! Form::close() !!}
@endsection