@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('static.menu-register') }}</div>
                    {!! Form::open(['method' => 'post', 'url' => route('department::auth::register', [$department->keyword])]) !!}
                        <div class="panel-body">
                            @include('layouts.partials.messages.errors')
                            <div class="mt text-center">
                                <label>{{ trans('static.personal-information') }}</label>
                            </div>
                            <div class="form-group">
                                <label for="inputRank">{{ trans('static.rank') }}</label>
                                {!! Form::select('rank_id', $ranks, old('rank_id'), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label for="inputName">{{ trans('static.name') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                                <input name="name" type="text" class="form-control" id="inputName" placeholder="{{ trans('static.name') }}" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="inputPhone">{{ trans('static.phone') }}</label>
                                <input name="phone" type="text" class="form-control" id="inputPhone" placeholder="{{ trans('static.phone') }}" value="{{ old('phone') }}">
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">{{ trans('static.address') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                                <textarea name="address" rows="4" class="form-control" id="inputAddress" placeholder="{{ trans('static.address') }}">{{ old('address') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputInstitution">{{ trans('static.institution') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                                <input name="institution" type="text" class="form-control" id="inputInstitution" placeholder="{{ trans('static.institution') }}" value="{{ old('institution') }}">
                            </div>
                            <div class="form-group">
                                <label for="inputCountry">{{ trans('static.country') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                                {!! Form::select('country_id', $countries, old('country_id'), ['class' => 'form-control']) !!}
                            </div>
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
                    {!! Form::hidden('department_id', $department->id) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    {{--todo multiseclt--}}
@endsection