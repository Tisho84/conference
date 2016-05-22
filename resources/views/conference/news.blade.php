@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                @foreach ($news as $value)
                    <div class="news-wrapper mb20">
                        <div class="news-title">
                            <h1>{!! $value->langs->first()->title !!} <small class="pull-right">{!! $value->created_at !!}</small></h1>
                        </div>
                        <div class="news-description">{!! $value->langs->first()->description  !!}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="centered text-center news-pages">
        {!! $news->render() !!}
    </div>
@endsection