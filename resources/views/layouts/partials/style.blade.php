<style type="text/css">
    .department .navbar,
    .department .navbar .navbar-brand {
        color: {!! $department->theme_color  !!} !important;
        background-color: {!! $department->theme_background_color  !!} !important;
    }

    .department .navbar li a {
        color: {!! $department->theme_color  !!} !important;
    }

    .department .navbar li.active a {
        color: {!! $department->theme_background_color !!} !important;
    }

    .department #footer {
        border-color: {!! $department->theme_background_color  !!} !important;
    }

    .department .navbar-default .navbar-nav > .open > a,
    .department .navbar-default .navbar-nav > .open > a:hover,
    .department .navbar-default .navbar-nav > .open > a:focus,
    .department .navbar-default .dropdown-menu {
        background-color: {!! $department->theme_background_color  !!};
    }

    .department .dropdown-menu > li > a:hover,
    .department .dropdown-menu > li > a:focus {
        color: {!! $department->theme_background_color !!} !important;
    }

    .btn-theme {
        background-color: {!! $department->theme_background_color  !!};
        color: {!! $department->theme_color  !!} !important;
    }
</style>