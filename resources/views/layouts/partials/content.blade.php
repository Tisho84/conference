@extends('layouts.master')

@section('content')
    <div class="panel panel-default">
        <div class="container-fluid inner-content">
            <div class="row">
                <div class="col-sm12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                    <div class="panel panel-default mt">
                        @yield('inner-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection