<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ trans('admin.admin-login-form') }}</title>
    {!! HTML::style('/css/app.css') !!}
    {!! HTML::style('/css/admin.login.css') !!}
    <link href="{!!asset('navicon.ico') !!}" rel="shortcut icon" type="image/vnd.microsoft.icon" />
</head>

<body>
    <div class="login">
        <h1>{{ trans('static.menu-login') }}</h1>
        @include('layouts.partials.messages.errors')
        {!! Form::open(['method' => 'post', 'url' => action('HomeController@postLogin')]) !!}
            <input type="text" name="email" placeholder="{{ trans('static.email') }}" required="required" />
            <input type="password" name="password" placeholder="{{ trans('static.password') }}" required="required" />
            <button type="submit" class="btn btn-primary btn-block btn-large">{{ trans('admin.let-me-in') }}</button>
        {!! Form::close() !!}
    </div>
    {!! HTML::script('/js/prefixfree.min.js') !!}
</body>
</html>
