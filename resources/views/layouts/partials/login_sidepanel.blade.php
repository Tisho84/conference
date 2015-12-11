<!-- sidebar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
    <ul class="nav">
        <li>{!! HTML::link(route('department::user::profile', [$department->keyword]), trans('static.profile-information')) !!}</li>
        <li><a href="#">Link 3</a></li>
    </ul>
</div>

