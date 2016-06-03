@extends('layouts.partials.content')

@section('inner-content')
    <div class="panel-heading">{{ trans('static.menu-login') }}</div>
    <div class="panel-body">
        @include('layouts.partials.messages.errors')
        {!! Form::open(['method' => 'post', 'url' => route('department::auth::login', [$department->keyword])]) !!}
            <div class="col-md text-center">
                <label>{{ trans('static.login-title') }}</label>
            </div>
            <div class="form-group">
                <label for="inputEmail">{{ trans('static.email') }}</label>
                <input name="email" type="email" class="form-control" id="inputEmail" placeholder="{{ trans('static.email') }}" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="inputPassword">{{ trans('static.password') }}</label>
                <input name="password" type="password" class="form-control" id="inputPassword" placeholder="{{ trans('static.password') }}">
            </div>
            <div class="checkbox">
                 <label>
                     <input type="checkbox" name="remember" value="value">{{ trans('static.remember-me') }}
                 </label>
            </div>
            <div class="form-group">
                <a class="btn btn-link" href="{{ route('department::auth::reset_pass', [$department->keyword]) }}">{{ trans('static.forgot-password') . ' ?' }}</a>
                {!! HTML::link(route('department::auth::register', [$department->keyword]), trans('static.register-author'), ['class' => 'btn btn-link']) !!}
                {!! HTML::link(route('department::auth::register', [$department->keyword, 'reviewer' => 1]), trans('static.register-reviewer'), ['class' => 'btn btn-link']) !!}
            </div>
            <div class="form-group">
                <div class="text-center">
                    <button type="submit" class="btn btn-theme">{{ trans('static.menu-login') }}</button>
                    <button type="reset" class="btn btn-default">{{ trans('static.clear') }}</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection