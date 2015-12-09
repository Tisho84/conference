<li>{!! HTML::link(route('department::user::profile', [$department->keyword]), trans('static.menu-account')) !!}</li>
<li>{!! HTML::link('#', trans('static.menu-papers')) !!}</li>
<li>{!! HTML::link('#', trans('static.menu-about')) !!}</li>
<li>{!! HTML::link('http://tu-varna.bg', trans('static.menu-tu-varna'),['target' => '_blank']) !!}</li>
<li>{!! HTML::link(route('department::user::logout', [$department->keyword]), trans('static.menu-logout')) !!}</li>
