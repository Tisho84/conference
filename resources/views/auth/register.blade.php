@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('static.menu-register') }}</div>
                    <div class="panel-body">
                        @include('layouts.partials.messages.errors')
                        {!! Form::open(['method' => 'post', 'url' => route('department::auth::register', [$department->keyword])]) !!}
                        <div class="col-md text-center">
                            <label>
                                @if (request()->get('reviewer'))
                                    {{ trans('static.register-reviewer') }}
                                @else
                                    {{ trans('static.register-author') }}
                                @endif
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="inputName">{{ trans('static.name') }}</label>
                            <input name="name" type="text" class="form-control" id="inputName" placeholder="{{ trans('static.name') }}" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">{{ trans('static.email') }}</label>
                            <input name="email" type="email" class="form-control" id="inputEmail" placeholder="{{ trans('static.email') }}" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">{{ trans('static.password') }}</label>
                            <input name="password" type="password" class="form-control" id="inputPassword" placeholder="{{ trans('static.password') }}">
                        </div>
                        <div class="form-group">
                            <label for="inputPasswordConfirm">{{ trans('static.password-confirm') }}</label>
                            <input name="password_confirmation" type="password" class="form-control" id="inputPasswordConfirm" placeholder="{{ trans('static.password-confirm') }}">
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-theme">{{ trans('static.menu-register') }}</button>
                                <button type="reset" class="btn btn-default">{{ trans('static.clear') }}</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection