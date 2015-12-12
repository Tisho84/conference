@extends('layouts.master')

@section('content')
    <div class="container-fluid inner-content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @yield('inner-content')
                </div>
            </div>
        </div>
    </div>
@endsection