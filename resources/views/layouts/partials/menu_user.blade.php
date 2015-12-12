<li>
    <a href="javascript:void(0);" class="dropdown-toggle" id="registerMenu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        {{ trans('static.menu-account') }}
    </a>
    <ul class="dropdown-menu" aria-labelledby="registerMenu">
        <li>{!! HTML::link(route('department::user::profile', [$department->keyword]), trans('static.profile-information')) !!}</li>
        <li>{!! HTML::link(route('department::user::change', [$department->keyword]), trans('static.change-password')) !!}</li>
    </ul>
</li>
<li>{!! HTML::link('#', trans('static.menu-papers')) !!}</li>
<li>{!! HTML::link('#', trans('static.menu-about')) !!}</li>
<li>{!! HTML::link('http://tu-varna.bg', trans('static.menu-tu-varna'),['target' => '_blank']) !!}</li>
<li>{!! HTML::link(route('department::user::logout', [$department->keyword]), trans('static.menu-logout')) !!}</li>
