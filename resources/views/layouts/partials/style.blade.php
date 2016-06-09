<style type="text/css">
    .department .navbar,
    .department .navbar .navbar-brand {
        color: {!! $department->theme_color  !!} !important;
        background-color: {!! $department->theme_background_color  !!} !important;
    }

    .department .navbar li a {
        color: {!! $department->theme_color  !!} !important;
    }

    .department .navbar li.open > a {
        color: {!! $department->theme_background_color !!} !important;
    }

    .department .navbar li:not(.open).active a {
        color: {!! $department->theme_background_color !!} !important;
    }

    .department #footer {
        border-color: {!! $department->theme_background_color  !!} !important;
    }

    .department .navbar-default .navbar-nav > li.open:not(.active) > a,
    .department .navbar-default .navbar-nav > li.open:not(.active) > a:hover,
    .department .navbar-default .navbar-nav > li.open:not(.active) > a:focus,
    .department .navbar-default .dropdown-menu {
        background-color: {!! $department->theme_background_color  !!};
    }

    .department .navbar li.open:not(.active) > a {
        color: {!! $department->theme_color !!} !important;
    }

    .department .dropdown-menu > li > a:hover,
    .department .dropdown-menu > li > a:focus {
        color: {!! $department->theme_background_color !!} !important;
    }

    .btn-theme {
        background-color: {!! $department->theme_background_color  !!};
        color: {!! $department->theme_color  !!} !important;
    }

    #sidebar li {
        {{--border: 0 {!! $department->theme_background_color !!} solid !important;--}}
    }

    .pagination > .active > a,
    .pagination > .active > a:hover,
    .pagination > .active > a:focus,
    .pagination > .active > span,
    .pagination > .active > span:hover,
    .pagination > .active > span:focus {
        background-color: {!! $department->theme_background_color  !!};
        border-color: {!! $department->theme_background_color  !!};
    }
</style>