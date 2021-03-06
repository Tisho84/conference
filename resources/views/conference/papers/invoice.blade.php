@extends('layouts.partials.content')

@section('inner-content')
    <div class="panel-heading">{{ trans('static.adding-invoice') }}</div>
    <div class="panel-body">
        @include('layouts.partials.messages.errors')
        {!! Form::model($paper, ['method' => 'post', 'url' => action('PaperController@postInvoice', [$department->keyword, $paper->id]), 'files' => true]) !!}
            <div class="form-group">
                <label for="payment_description">{{ trans('static.invoice-description') }}</label>
                {!! Form::textarea("payment_description", null, ['class' => 'form-control ', 'id' => 'payment_description', 'placeholder' => trans('static.invoice-description')]) !!}
            </div>
            @if ($paper->payment_confirmed)
                <div class="form-group">
                    <label>{{ trans('static.download')}}:</label>
                    <label class="control-label">{!! HTML::link('papers/' . $department->keyword . '/' . rawurlencode($paper->payment_source), $paper->payment_source) !!}</label>
                </div>
            @endif
            <div class="form-group">
                <label for="payment_source">{{ trans('static.invoice-source') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                {!! Form::file("payment_source", null, ['class' => 'form-control', 'id' => 'payment_source', 'placeholder' => trans('static.invoice-source')]) !!}
            </div>
            <div class="form-group">
                <div class="text-center">
                    <a href="{{ action('PaperController@index', [$department->keyword]) }}" class="btn btn-theme">{{ trans('static.menu-back') }}</a>
                    <button type="submit" class="btn btn-theme">{{ trans('static.save') }}</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection