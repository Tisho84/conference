<li {{ setActive('/auth/login') }}>{!! HTML::link(route('department::auth::login', [$department->keyword]), trans('static.menu-login')) !!}</li>
<li {{ setActive('/auth/register') }}>
    <a href="javascript:void(0);" class="dropdown-toggle" id="registerMenu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        {{ trans('static.menu-register') }}
    </a>
    <ul class="dropdown-menu" aria-labelledby="registerMenu">
        <li>{!! HTML::link(route('department::auth::register', [$department->keyword]), trans('static.register-author')) !!}</li>
        <li>{!! HTML::link(route('department::auth::register', [$department->keyword, 'reviewer' => 1]), trans('static.register-reviewer')) !!}</li>
    </ul>
</li>
@if ($department->url)
    <li>{!! HTML::link($department->url, trans('static.to-page')) !!}</li>
@endif
<li>{!! HTML::link('http://tu-varna.bg', trans('static.menu-tu-varna'), ['target' => '_blank']) !!}</li>
