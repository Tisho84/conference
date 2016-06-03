@extends('layouts.partials.content')

@section('inner-content')
    <div class="panel-heading">{{ trans('static.forgot-password') }}</div>
    <div class="panel-body">
        @include('layouts.partials.messages.errors')
        {!! Form::open(['method' => 'post', 'url' => route('department::auth::reset_token', [$department->keyword])]) !!}
            <div class="col-md text-center">
                <label>{{ trans('static.password-reset') }}</label>
            </div>
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="inputEmail">{{ trans('static.email') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                <input name="email" type="email" class="form-control" id="inputEmail" placeholder="{{ trans('static.email') }}" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="inputPassword">{{ trans('static.password') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                <input name="password" type="password" class="form-control" id="inputPassword" placeholder="{{ trans('static.password') }}">
            </div>
            <div class="form-group">
                <label for="inputPasswordConfirm">{{ trans('static.password-confirm') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                <input name="password_confirmation" type="password" class="form-control" id="inputPasswordConfirm" placeholder="{{ trans('static.password-confirm') }}">
            </div>

            <div class="form-group">
                <div class="text-center">
                    <button type="submit" class="btn btn-theme">{{ trans('static.send') }}</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection