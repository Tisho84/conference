@extends('layouts.partials.content')

@section('inner-content')
    <div class="panel-heading">{{ trans('static.profile-information') }}</div>
    {!! Form::model(auth()->user(), ['url' => route('department::user::profile', [$department->keyword]), 'method' => 'put']) !!}
        <div class="panel-body">
            @include('layouts.partials.messages.errors')
            @include('auth.personal_form')
            @if (!isset($disabled) || (isset($disabled) && !$disabled))
                <div class="form-group">
                    <div class="text-center">
                        <button type="submit" class="btn btn-theme">{{ trans('static.save') }}</button>
                    </div>
                </div>
            @endif
        </div>
    {!! Form::close() !!}
@endsection