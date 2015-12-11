@if (Session::has('success'))
    <div class="alert alert-success">
        {{ trans('messages.' . Session::pull('success')) }}
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger">
        {{ trans('messages.' . Session::pull('error')) }}
    </div>
@endif

@if (Session::has('info'))
    <div class="alert alert-info">
        {{ trans('messages.' . Session::pull('info')) }}
    </div>
@endif

@if (Session::has('warning'))
    <div class="alert alert-warning">
        {{ trans('messages.' . Session::pull('warning')) }}
    </div>
@endif