@extends('layouts.partials.content')

@section('inner-content')
    <div class="panel-heading">{{ trans('static.forgot-password') }}</div>
    <div class="panel-body">
        @include('layouts.partials.messages.errors')
        {!! Form::open(['method' => 'post', 'url' => route('department::auth::reset_pass', [$department->keyword])]) !!}
            <div class="col-md text-center">
                <label>{{ trans('static.password-title') }}</label>
            </div>
            <div class="form-group">
                <label for="inputEmail">{{ trans('static.email') }}</label>
                <input name="email" type="email" class="form-control" id="inputEmail" placeholder="{{ trans('static.email') }}" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <div class="text-center">
                    <button type="submit" class="btn btn-theme">{{ trans('static.send') }}</button>
                    <a class="btn btn-default" href="{{ route('department::auth::login', [$department->keyword]) }}">{{ trans('static.menu-back') }}</a>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection