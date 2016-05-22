<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.partials.head')
        {!! HTML::style('/css/sb-admin.css') !!}
        {!! HTML::style('/css/select2.css') !!}

        {!! HTML::script('/js/all.js') !!}
        {!! HTML::script('/js/select2.js') !!}
    </head>
    <body>
        <div id="wrapper" class="admin">
            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    {{--<a class="navbar-brand" href="index.html">SB Admin</a>--}}
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    @include('layouts.partials.language_dropdown')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu alert-dropdown">
                            <li>
                                <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">View All</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ auth()->user()->name }} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#"><i class="fa fa-fw fa-power-off"></i>{!! trans('static.menu-logout') !!}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        @if (systemAccess(10))
                            <li>{!! HTML::link(action('Admin\DepartmentController@index'), trans('admin.departments')) !!}</li>
                        @endif
                        @if (systemAccess(100))
                            <li>{!! HTML::link(action('Admin\UserTypesController@index'), trans('admin.user-types')) !!}</li>
                        @endif
                        @if (systemAccess(5))
                            <li>{!! HTML::link(action('Admin\UsersController@index'), trans('admin.users')) !!}</li>
                        @endif
                        @if (systemAccess(4))
                            <li>{!! HTML::link(action('Admin\NewsController@index'), trans('static.news')) !!}</li>
                        @endif
                        @if (systemAccess(7))
                            <li>{!! HTML::link(action('Admin\CategoryController@index'), trans('admin.categories')) !!}</li>
                        @endif
                        <li>{!! HTML::link(action('Admin\PaperController@index'), trans('static.menu-papers')) !!}</li>
                        @if (systemAccess(6))
                            <li>{!! HTML::link(action('Admin\CriteriaController@index'), trans('static.criteria')) !!}</li>
                        @endif
                        @if (systemAccess(8))
                            <li>{!! HTML::link(action('Admin\SettingsController@display'), trans('static.settings')) !!}</li>
                        @endif
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
            <div id="page-wrapper">
                <div class="messages">
                    @include('layouts.partials.messages.other')
                </div>
                @if(isset($back) && $back)
                    <div class="admin-back pull-left">
                        <a href="{{ $back }}" class="btn btn-primary btn-sm">{{ trans('static.menu-back') }}</a>
                    </div>
                @endif
                <div class="clearfix"></div>
                <div class="content container-fluid">
                    <div class="panel panel-default">
                        @yield('content')
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        @yield('javascript')
        {!! HTML::script('/js/app.js') !!}
    </body>
</html>