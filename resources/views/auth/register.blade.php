@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
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
                            <div class="form-group">
                                <label for="inputEmail">{{ trans('static.email') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                                <input name="email" type="email" class="form-control" id="inputEmail" placeholder="{{ trans('static.email') }}" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <label for="inputEmail2">{{ trans('static.email2') }}</label>
                                <input name="email2" type="email" class="form-control" id="inputEmail2" placeholder="{{ trans('static.email2') }}" value="{{ old('email2') }}">
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
                                    <button type="submit" class="btn btn-theme">{{ trans('static.menu-register') }}</button>
                                    <button type="reset" class="btn btn-default">{{ trans('static.clear') }}</button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    {{--todo multiseclt--}}
@endsection