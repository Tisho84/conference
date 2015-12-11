@extends('layouts.master')

@section('content')
    <div class="row row-offcanvas row-offcanvas-left">
        @include('layouts.partials.login_sidepanel')
        <div class="col-xs-12 col-sm-10 login-sidepanel-right">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('static.profile-information') }}</div>
                {!! Form::model(auth()->user(), ['url' => route('department::user::profile', [$department->keyword]), 'method' => 'put']) !!}
                    <div class="panel-body">
                        @include('layouts.partials.messages.errors')
                        @include('auth.personal_form')
                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-theme">{{ trans('static.save') }}</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div><!-- /.col-xs-12 main -->
    </div><!--/.row-->

@endsection