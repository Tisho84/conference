@if (Session::has('success'))
    <div class="alert alert-success">
        {{ trans('messages.' . Session::get('success')) }}
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger">
        {{ trans('messages.' . Session::get('error')) }}
    </div>
@endif

@if (Session::has('info'))
    <div class="alert alert-info">
        {{ trans('messages.' . Session::get('info')) }}
    </div>
@endif

@if (Session::has('warning'))
    <div class="alert alert-warning">
        {{ trans('messages.' . Session::get('warning')) }}
    </div>
@endif